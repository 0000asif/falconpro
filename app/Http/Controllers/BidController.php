<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Type;
use App\Models\BidsItem;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bids = Bid::all();
        return view('bids.index', compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workOrders = WorkOrder::where('status', '1')->get();
        $types = Type::all();
        return view('bids.create', compact('workOrders', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'work_order_id' => 'required',
            'type.*' => 'nullable|exists:types,id',
            'description.*' => 'nullable|string',
            'qty.*' => 'nullable|numeric|min:0',
            'unit_price.*' => 'nullable|numeric|min:0',
            'total_price.*' => 'nullable|numeric|min:0',
        ]);
        $data = $request->all();

        //store image and save to database
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin/bids'), $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = null;
        }
        // Store Work Order
        $bid = Bid::create([
            'user_id' => auth()->user()->id,
            'work_order_id' => $request->work_order_id,
            'image' => $data['image'],
            'status' => 1, // Initially active status
            'total_amount' => 0,
            'total_qty' => 0,
        ]);


        $grandTotal = 0;
        $totalQty = 0;

        // Store Work Order Items
        if ($request->has('type')) {
            foreach ($request->type as $index => $type) {
                if (!empty($type) && !empty($request->qty[$index]) && !empty($request->unit_price[$index])) {
                    $totalPrice = $request->qty[$index] * $request->unit_price[$index];
                    $grandTotal += $totalPrice;
                    $totalQty += $request->qty[$index]; // Sum up the total quantity

                    BidsItem::create([
                        'bid_id' => $bid->id,
                        'type_id' => $type,
                        'description' => $request->description[$index],
                        'qty' => $request->qty[$index],
                        'unit_price' => $request->unit_price[$index],
                        'total_price' => $totalPrice,
                    ]);
                }
            }
        }
        // Update Grand Total and Total Quantity
        $bid->update([
            'total_amount' => $grandTotal,
            'total_qty' => $totalQty,
        ]);
        return redirect()->back()->with('success', 'Bid created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bid = Bid::with(['items'])->find($id);
        return view('bids.show', compact('bid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bid = Bid::with('items')->find($id);
        // dd($bid);
        $types = Type::all();
        return view('bids.edit', compact('bid', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'work_order_id' => 'required|exists:work_orders,id',
            'status' => 'required',
            'type.*' => 'nullable|exists:types,id',
            'description.*' => 'nullable|string|max:500',
            'qty.*' => 'nullable|numeric|min:0',
            'unit_price.*' => 'nullable|numeric|min:0',
            'total_price.*' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Fetch the existing Bid
        $bid = Bid::find($id);

        // Handle image update
        $data = $request->all();
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($bid->image && file_exists(public_path('admin/bids/' . $bid->image))) {
                unlink(public_path('admin/bids/' . $bid->image));
            }

            // Store new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin/bids'), $imageName);
            $data['image'] = $imageName;
        } else {
            $data['image'] = $bid->image; // Retain old image if no new one is uploaded
        }

        // Update main bid details
        $bid->update([
            'work_order_id' => $request->work_order_id,
            'image' => $data['image'],
            'status' => $request->status,
        ]);

        $grandTotal = 0;
        $totalQty = 0;

        // Sync Bid Items
        $existingItemIds = $bid->items->pluck('id')->toArray();
        $submittedItemIds = $request->input('item_id', []);

        // Delete removed items
        $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
        BidsItem::whereIn('id', $itemsToDelete)->delete();

        // Update or create items
        $types = $request->input('type', []);
        $descriptions = $request->input('description', []);
        $quantities = $request->input('qty', []);
        $unitPrices = $request->input('unit_price', []);
        $totalPrices = $request->input('total_price', []);

        foreach ($types as $index => $typeId) {
            $itemData = [
                'type_id' => $typeId,
                'description' => $descriptions[$index] ?? null,
                'qty' => $quantities[$index] ?? 0,
                'unit_price' => $unitPrices[$index] ?? 0,
                'total_price' => ($quantities[$index] ?? 0) * ($unitPrices[$index] ?? 0),
            ];

            $grandTotal += $itemData['total_price'];
            $totalQty += $itemData['qty'];

            if (isset($submittedItemIds[$index])) {
                // Update existing item
                BidsItem::where('id', $submittedItemIds[$index])->update($itemData);
            } else {
                // Create new item
                $bid->items()->create($itemData);
            }
        }



        // Update grand total and total quantity in bid
        $bid->update([
            'total_amount' => $grandTotal,
            'total_qty' => $totalQty,
        ]);

        return back()->with('success', 'Bid updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        // Delete image if exists
        if ($bid->image && file_exists(public_path('admin/bids/' . $bid->image))) {
            unlink(public_path('admin/bids/' . $bid->image));
        }

        $bid->delete();
        return back()->with('success', 'Bid deleted successfully.');
    }

    public function createbids($id)
    {
        $workOrder = WorkOrder::find($id);
        $types = Type::all();
        return view('bids.createbids', compact('workOrder', 'types'));
    }


    public function print($id)
    {
        $bids = Bid::where('work_order_id', $id)->with('items', 'workOrder')->get();
        return view('bids.print', compact('bids'));
    }
}
