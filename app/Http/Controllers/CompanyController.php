<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Employee;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('city', 'state')->get();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = State::all();
        return view('company.create', compact('state'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required'],
            'city' => ['nullable', 'string', 'max:255'],
            'state_id' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:255'],
            'image' => 'required',
            'status' => ['required', 'integer'],
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('admin/company'), $imageName);
            $data['image'] = $imageName;
        }
        // Create a new company
        $company = Company::create($data);

        // Redirect to the company index page
        return redirect()->route('company.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $entry = Company::findOrFail($id);
        return view('company.edit', compact('entry'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'city'   => 'nullable|string',
            'state_id'  => 'required|string',
            'name'      => 'required|string|max:255',
            'image' => 'nullable',
            'zip_code'  => 'required|string|max:10',
            'address'   => 'required|string',
            'status'    => 'required|in:0,1',
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        $entry = Company::findOrFail($id);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            $image_path = public_path("admin/company/") . $entry->image;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }

            // Upload the new image and update the image name
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('admin/company'), $imageName);
            $validatedData['image'] = $imageName;
        } else {
            // Keep the old image if no new image is uploaded
            $validatedData['image'] = $entry->image;
        }
        $entry->update($validatedData);

        return redirect()->route('company.index')->with('success', 'Record updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $clientid = Client::where('company_id', $company->id)->exists();
        $vendorid = Vendor::where('company_id', $company->id)->exists();
        $employeeid = Employee::where('company_id', $company->id)->exists();
        $workorderid = WorkOrder::where('company_id', $company->id)->exists();
        if ($clientid || $vendorid || $employeeid || $workorderid) {
            return redirect()->route('company.index')->with('failed', 'Cannot delete company while it has associated records.');
        }
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Record deleted successfully!');
    }

    public function view($id)
    {
        $company = Company::with('workOrders.client', 'workOrders.vendor')->find($id);
        return view('company.show', compact('company'));
    }
}