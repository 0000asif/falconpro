<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use App\Models\WorkOrderItem;
use App\Models\ClientInvoiceItem;
use App\Models\VendorInvoiceItem;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:types|max:255',
            'status' => 'required',
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->id();
        Type::create($data);
        return redirect()->route('type.index')->with('success', 'Type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type = Type::find($id);
        $request->validate([
            'name' => 'required|unique:types,name,' . $type->id . '|max:255',
            'status' => 'required',
        ]);
        $data = $request->all();
        $type->update($data);
        return redirect()->route('type.index')->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $workorderid = WorkOrderItem::where('type_id', $type->id)->exists();
        $clientinvoiceid = ClientInvoiceItem::where('type_id', $type->id)->exists();
        $vendorinvoiceid = VendorInvoiceItem::where('type_id', $type->id)->exists();
        if ($workorderid || $clientinvoiceid || $vendorinvoiceid) {
            return redirect()->route('type.index')->with('failed', 'Type cannot be deleted because it is associated with work orders, client invoices, or vendor invoices.');
        }
        $type->delete();
        return redirect()->route('type.index')->with('success', 'Type deleted successfully.');
    }
}