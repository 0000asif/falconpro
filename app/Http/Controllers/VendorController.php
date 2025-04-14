<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Expertise;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $companyId;

    public function index(Request $request)
    {

        $this->companyId = getuser();

        if($this->companyId){
            $companyId  = $this->companyId;
        }else{
            $companyId  = $request->get('company_id');
        }

        if ($companyId) {
            $companies  = Company::where('id', $companyId)->get();
            $vendors    = Vendor::where('company_id', $companyId)->get();
        }else{
            $companies  = Company::get();
            $vendors    = Vendor::get();
        }
        return view('vendor.index', compact('vendors', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->companyId = getuser();
        $expertise = Expertise::all();
        if($this->companyId){
            $company = Company::where('id', $this->companyId)->first();
        }else{
            $company = Company::where('status', '1')->get();
        }

        $role_permissions   = Role::with('permissions')->get();

        return view('vendor.create', compact('expertise', 'company', 'role_permissions'));
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email', 'max:255'],
            'company_id' => ['required', 'integer'],
            'expertise' => ['nullable'],
            'address' => ['required', 'string', 'max:255'],
            'city_id' => ['nullable', 'string', 'max:255'],
            'state_id' => ['required', 'string', 'max:255'],
            'zip_code' => ['required'],
            'status' => ['required', 'boolean'],
        ]);
    

        
        
        try {
            DB::beginTransaction();

            $email = $request->input('email');
            $existingemail = User::where('email', $email)->exists();
            if ($existingemail) {
                return back()->with('failed', 'Email already exists!');
            }

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('phone'));
            $user->save();

            $user->assignRole($request->user_role);

            $existingemail = Vendor::where('email', $email)->exists();
            if ($existingemail) {
                return back()->with('failed', 'Email already exists!');
            }
            $data = $request->all();
            $data['user_id'] = $user->id;
            Vendor::create($data);

            DB::commit();
            return redirect()->route('vandors.index')->with('success', 'Vendor created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create vendor. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor     = Vendor::find($id);
        $expertise  = Expertise::all();
        $this->companyId = getuser();

        if($this->companyId){
            $company = Company::where('id', $this->companyId)->get();
        }else{
            $company = Company::where('id', $vendor->company_id)->get();
        }
        $role_permissions   = Role::with('permissions')->get();
        return view('vendor.edit', compact('vendor', 'expertise', 'company', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email', 'max:255'],
            'company_id' => ['required', 'integer'],
            'expertise' => ['nullable'],
            'address' => ['required', 'string', 'max:255'],
            'city_id' => ['nullable', 'string', 'max:255'],
            'state_id' => ['required', 'string', 'max:255'],
            'zip_code' => ['required'],
            'status' => ['required', 'boolean'],
        ]);


        try {
            DB::beginTransaction();

            $user = User::where('id', $vendor->user_id)->first();
            $email = $request->input('email');
            $existingemail = User::where('email', $email)->where('id', '!=', $user->id)->exists();
            if ($existingemail) {
                return back()->with('failed', 'Email already exists');
            }
            $user->name = $request->input('name');
            $user->email = $email;
            $user->password = Hash::make($request->input('phone'));
            $user->save();

            $existingemail = Vendor::where('email', $email)->where('id', '!=', $vendor->id)->exists();
            if ($existingemail) {
                return back()->with('failed', 'Email already exists');
            }
            $data           = $request->all();
            $vendor->update($data);

            $user_info = User::where('id', $vendor->user_id)->first();
            $user_info->type = $request->user_role;
            if($request->user_role){
                $user_info->assignRole($request->user_role);
            }
            $user_info->save();

            DB::commit();
            return redirect()->route('vandors.index')->with('success', 'Vendor updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vandors.index')->with('failed', 'Failed to update vendor. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $vendor = Vendor::find($id);
            $workorderid = WorkOrder::where('vendor_id', $vendor->id)->exists();
            if ($workorderid) {
                return redirect()->route('vandors.index')->with('failed', 'Vendor cannot be deleted as it has associated work orders.');
            }
            $vendor->delete();
            $user = User::where('id', $vendor->user_id)->first();
            $user->delete();
            DB::commit();
            return redirect()->route('vandors.index')->with('success', 'Vendor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vandors.index')->with('error', 'Failed to delete vendor. Please try again.');
        }
    }
}