<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Bid;
use App\Models\City;
use App\Models\Note;
use App\Models\Type;
use App\Models\User;
use App\Models\State;
use App\Models\Client;
use App\Models\Status;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use App\Models\ClientInvoice;
use App\Models\VendorInvoice;
use App\Models\WorkOrderItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{

    protected $companyId;
    public function __construct() {}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $companyId = getuser();

        if ($companyId) {
            $companyId = $companyId;
        } else {
            $companyId = $request->get('company_id');
        }

        if ($companyId) {
            $workOrders = WorkOrder::with(['client', 'vendor', 'company', 'status'])->where('company_id', $companyId)->get();
        } else {
            $workOrders = WorkOrder::with(['client', 'vendor', 'company', 'status'])->get();
        }
        if ($companyId) {
            $companies = Company::where('id', $companyId)->get();
        } else {
            $companies = Company::get();
        }

        return view('workorder.index', compact('workOrders', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types      = Type::where('status', 1)->get();
        $status     = Status::all();

        $this->companyId = getuser();

        if ($this->companyId) {
            $clients    = Client::where('status', 1)->where('company_id', $this->companyId)->get();
            $vendors    = Vendor::where('status', 1)->where('company_id', $this->companyId)->get();
            $companies  = Company::where('status', 1)->where('id', $this->companyId)->get();
        } else {
            $clients    = Client::where('status', 1)->get();
            $vendors    = Vendor::where('status', 1)->get();
            $companies  = Company::where('status', 1)->get();
        }

        return view('workorder.create', compact('types', 'clients', 'vendors', 'companies', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'work_order_number' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'company_id' => 'required|exists:companies,id',
            'state_id' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string',
            'status_id' => 'required',
            'due_date' => 'required',
            'type.*' => 'nullable|exists:types,id',
            'description.*' => 'nullable|string',
            'qty.*' => 'nullable|integer|min:1',
            'unit_price.*' => 'nullable|numeric|min:0',
            'total_price.*' => 'nullable|numeric|min:0',
            'file' => 'nullable',
        ]);
        DB::beginTransaction(); // Start the transaction

        try {
            $lastInvoice = WorkOrder::where('company_id', $request->company_id)
                ->orderBy('id', 'desc')
                ->value('invoice'); // Fetch the last invoice number for this company

            // Determine the next invoice number
            $nextInvoiceNumber = $lastInvoice ? (int) $lastInvoice + 1 : 1;

            $company_info = WorkOrder::where('company_id', $request->company_id)->orderBy('id', 'desc')->first();
            if ($company_info) {
                $company_order_number = $company_info->company_order_number + 1;
            } else {
                $company_order_number = 1;
            }

            if ($request->file) {
                $file_name = time() . "." . $request->file->extension();
                $request->file->move(public_path('images/work-order/'), $file_name);
            } else {
                $file_name = null;
            }

            $due_date = Carbon::createFromFormat('m-d-Y', $validatedData['due_date'])->format('Y-m-d');

            $workOrder = WorkOrder::create([
                'user_id' => auth()->id(),
                'work_order_number' => $request->work_order_number,
                'company_order_number' => $company_order_number,
                'client_id' => $request->client_id,
                'vendor_id' => $request->vendor_id,
                'company_id' => $request->company_id,
                'invoice' => $nextInvoiceNumber, // Use the formatted invoice
                'state_id' => $request->state_id,
                'zip_code' => $request->zip_code,
                'address' => $request->address,
                'status_id' => $request->status_id,
                'due_date' => $due_date,
                'grand_total' => 0, // Initial value, calculated later
                'total_qty' => 0,   // Initial value, calculated later
                'file' => $file_name, // File name store database
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

                        WorkOrderItem::create([
                            'work_order_id' => $workOrder->id,
                            'type_id' => $type,
                            'description' => $request->description[$index],
                            'qty' => $request->qty[$index],
                            'unit_price' => $request->unit_price[$index],
                            'total_price' => $totalPrice,
                        ]);
                    }
                }
            }

            $workOrder->update([
                'grand_total' => $grandTotal,
                'total_qty' => $totalQty,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Work Order created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyId  = getuser();
        $user       = Auth::user();

        if (Auth::check()) {
            if ($user->client) {
                $vendor = 2;
            } elseif ($user->vendor) {
                $vendor = 1;
            } else {
                $vendor = 2;
            }
        } else {
            $vendor     = 2;
        }

        $workOrder  = WorkOrder::with(['client', 'vendor', 'company', 'items'])->find($id);
        if ($vendor) {
            $comments   = Note::where('work_order_id', $id)->where('status', '1')->where('show_to_vendor', '0')->orderByDesc('id')->get();
        } else {
            $comments   = Note::where('work_order_id', $id)->where('status', '1')->orderByDesc('id')->get();
        }

        $bids       = Bid::where('work_order_id', $id)->with('items')->get();

        $clientinvoice = ClientInvoice::where('work_order_id', $id)->with('items')->get();
        $vendorinvoice = VendorInvoice::where('work_order_id', $id)->with('items')->get();


        return view('workorder.show', compact('workOrder', 'comments', 'bids', 'clientinvoice', 'vendorinvoice', 'vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $workOrder = WorkOrder::with('items')->findOrFail($id);
        $status = Status::all();
        $types = Type::all();

        $this->companyId = getuser();

        if ($this->companyId) {
            $clients    = Client::where('company_id', $this->companyId)->get();
            $vendors    = Vendor::where('company_id', $this->companyId)->get();
            $companies  = Company::where('id', $this->companyId)->get();
        } else {
            $clients    = Client::get();
            $vendors    = Vendor::get();
            $companies  = Company::get();
        }


        return view('workorder.edit', compact('workOrder', 'clients', 'vendors', 'companies', 'types', 'status'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'work_order_number' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'client_id' => 'required|exists:clients,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'state_id' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string|max:500',
            'due_date' => 'required|date_format:m-d-Y',
            'status_id' => 'required|exists:statuses,id',
            'type' => 'required|array',
            'type.*' => 'required|exists:types,id',
            'description' => 'required|array',
            'description.*' => 'nullable|string|max:500',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
            'unit_price' => 'required|array',
            'unit_price.*' => 'required|numeric|min:0',
            'file' => 'nullable|mimes:jpg,png,webp,pdf,doc|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Fetch the existing work order
            $workOrder = WorkOrder::findOrFail($id);

            // Handle file upload
            $image_name = $workOrder->file;
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($workOrder->file) {
                    $old_file = public_path('images/work-order/' . $workOrder->file);
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }

                // Upload new file
                $file = $request->file('file');
                $image_name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/work-order/'), $image_name);
            }

            // Format due date
            $due_date = Carbon::createFromFormat('m-d-Y', $request->due_date)->format('Y-m-d');

            // Update the main work order fields
            $workOrder->update([
                'work_order_number' => $validated['work_order_number'],
                'company_id' => $validated['company_id'],
                'client_id' => $validated['client_id'],
                'vendor_id' => $validated['vendor_id'],
                'state_id' => $validated['state_id'],
                'zip_code' => $validated['zip_code'],
                'address' => $validated['address'],
                'due_date' => $due_date,
                'status_id' => $validated['status_id'],
                'file' => $image_name,
            ]);

            // Process work order items
            $grandTotal = 0;
            $totalQty = 0;
            $submittedItemIds = [];

            foreach ($request->type as $index => $typeId) {
                $totalPrice = $request->qty[$index] * $request->unit_price[$index];
                $grandTotal += $totalPrice;
                $totalQty += $request->qty[$index];

                $itemData = [
                    'type_id' => $typeId,
                    'description' => $request->description[$index] ?? null,
                    'qty' => $request->qty[$index],
                    'unit_price' => $request->unit_price[$index],
                    'total_price' => $totalPrice,
                ];

                // Check if this is an existing item (has item_id)
                if (isset($request->item_id[$index])) {
                    $item = WorkOrderItem::where('id', $request->item_id[$index])
                        ->where('work_order_id', $workOrder->id)
                        ->first();

                    if ($item) {
                        $item->update($itemData);
                        $submittedItemIds[] = $item->id;
                    }
                } else {
                    $newItem = $workOrder->items()->create($itemData);
                    $submittedItemIds[] = $newItem->id;
                }
            }

            // Delete any items not in the submitted list
            $workOrder->items()->whereNotIn('id', $submittedItemIds)->delete();

            // Update Grand Total and Total Quantity
            $workOrder->update([
                'grand_total' => $grandTotal,
                'total_qty' => $totalQty,
            ]);

            DB::commit();
            return redirect()->route('work-order.index')->with('success', 'Work Order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('failed', 'Error updating work order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkOrder  $workOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workOrder = WorkOrder::find($id);
        // dd($workOrder);
        DB::beginTransaction(); // Start the transaction
        try {
            $clientinvoieid = ClientInvoice::where('work_order_id', $workOrder->id)->exists();
            $venderinvoiceid = VendorInvoice::where('work_order_id', $workOrder->id)->exists();
            $bidid = Bid::where('work_order_id', $workOrder->id)->exists();
            $noteid = Note::where('work_order_id', $workOrder->id)->exists();
            if ($clientinvoieid || $venderinvoiceid || $bidid || $noteid) {
                return redirect()->back()->with('failed', 'This work order cannot be deleted as it has related records in other tables.');
            }


            if ($workOrder->file && file_exists(public_path('images/work-order/' . $workOrder->file))) {
                unlink(public_path('images/work-order/' . $workOrder->file)); // Delete the file
            }

            $workOrderItems = $workOrder->items;
            foreach ($workOrderItems as $item) {
                $item->delete();
            }
            $workOrder->delete();
            DB::commit(); // Commit the transaction if everything is successful
            return redirect()->route('work-order.index')->with('success', 'Work Order deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction if there is any failed
            return redirect()->back()->with('failed', 'Something went wrong. Please try again.');
        }
    }

    public function print($id)
    {
        $workOrder      = WorkOrder::with(['client', 'items', 'company', 'vendor', 'status'])->findOrFail($id);
        $comments       = Note::where('work_order_id', $id)->where('status', '1')->get();
        $bids           = Bid::where('work_order_id', $id)->with('items')->get();
        $clientinvoice  = ClientInvoice::where('work_order_id', $id)->with('items')->get();
        $vendorinvoice  = VendorInvoice::where('work_order_id', $id)->with('items')->get();
        return view('workorder.print', compact('workOrder', 'comments', 'bids', 'clientinvoice', 'vendorinvoice'));
    }
}
