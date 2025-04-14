<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Type;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use App\Models\ClientInvoice;
use App\Models\ClientInvoiceItem;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ClientInvoiceController extends Controller
{
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
        DB::beginTransaction();
        try {
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
            $clientinvoice = ClientInvoice::create([
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

                        ClientInvoiceItem::create([
                            'client_invoice_id' => $clientinvoice->id,
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
            $clientinvoice->update([
                'total_amount' => $grandTotal,
                'total_qty' => $totalQty,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Client Invoice created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('failed', 'An error occurred while creating the client invoice. Please try again.');
        }
    }
    public function clientinvoice($id)
    {
        $workOrder = WorkOrder::find($id);
        $types = Type::all();
        return view('clientinvoice.createinvoice', compact('workOrder', 'types'));
    }

    public function edit($id)
    {
        $clientInvoice = ClientInvoice::find($id);
        $workOrder = WorkOrder::find($id);
        $types = Type::all();
        return view('clientinvoice.edit', compact('workOrder', 'types', 'clientInvoice'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'work_order_id' => 'required',
            'type.*' => 'nullable|exists:types,id',
            'description.*' => 'nullable|string',
            'qty.*' => 'nullable|numeric|min:0',
            'unit_price.*' => 'nullable|numeric|min:0',
            'total_price.*' => 'nullable|numeric|min:0',
        ]);

        // Fetch the existing client invoice
        $clientInvoice = ClientInvoice::findOrFail($id);
        DB::beginTransaction();
        try {
            // Handle image upload (only if there's a new image)
            $data = $request->all();
            // dd($data, $clientInvoice);
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($clientInvoice->image && file_exists(public_path('admin/bids/' . $clientInvoice->image))) {
                    unlink(public_path('admin/bids/' . $clientInvoice->image));
                }

                // Store the new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('admin/bids'), $imageName);
                $data['image'] = $imageName;
            } else {
                // Retain the existing image if no new one is uploaded
                $data['image'] = $clientInvoice->image;
            }

            // Update the main client invoice details
            $clientInvoice->update([
                'work_order_id' => $request->work_order_id,
                'image' => $data['image'],
                'status' => $request->status,
                'total_amount' => 0, // Set the total to 0 before recalculating
                'total_qty' => 0, // Set the quantity to 0 before recalculating
            ]);

            // Recalculate the grand total and total quantity
            $grandTotal = 0;
            $totalQty = 0;

            // Handle item updates or creations
            if ($request->has('type')) {
                // First, delete existing items as they will be updated
                $clientInvoice->items()->delete();

                // Now, insert new or updated items
                foreach ($request->type as $index => $type) {
                    if (!empty($type) && !empty($request->qty[$index]) && !empty($request->unit_price[$index])) {
                        $totalPrice = $request->qty[$index] * $request->unit_price[$index];
                        $grandTotal += $totalPrice;
                        $totalQty += $request->qty[$index]; // Sum up the total quantity

                        ClientInvoiceItem::create([
                            'client_invoice_id' => $clientInvoice->id,
                            'type_id' => $type,
                            'description' => $request->description[$index],
                            'qty' => $request->qty[$index],
                            'unit_price' => $request->unit_price[$index],
                            'total_price' => $totalPrice,
                        ]);
                    }
                }
            }

            // Update the grand total and total quantity
            $clientInvoice->update([
                'total_amount' => $grandTotal,
                'total_qty' => $totalQty,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Client Invoice Updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while creating the client invoice. Please try again.');
        }
    }





    public function print($id)
    {
        $clientinvoice = ClientInvoice::where('work_order_id', $id)->with('items')->get();
        return view('clientinvoice.print', compact('clientinvoice'));
    }
}
