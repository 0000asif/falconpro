<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Designation;
use App\Models\SalaryRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $companyId = getuser();
        if ($companyId) {
            $companyId = getuser();
        } else {
            $companyId = $request->get('company_id');
        }

        $members = Employee::with('designation')->get();
        if ($companyId) {
            $members    = Employee::where('company_id', $companyId)->get();
            $companies  = Company::where('status', 1)->get();
        } else {
            $companies = Company::where('id', $companyId)->where('status', 1)->get();
        }

        return view('employee.index', compact('members', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Designation::all();
        $companyId = getuser();

        if ($companyId) {
            $companies  = Company::where('status', 1)->where('id', $companyId)->get();
        } else {
            $companies  = Company::where('status', 1)->get();
        }

        $role_permissions   = Role::with('permissions')->get();

        return view('employee.create', compact('positions', 'companies', 'role_permissions'));
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:10',
            'company_id' => ['nullable', 'integer'],
            'image' => 'nullable|image',
            'designation_id' => 'required',
            'join_date' => 'required',
            'salary' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $email = $request->input('email');
            $existingemail = User::where('email', $email)->exists();
            if ($existingemail) {
                return redirect()->route('employee.create')->with('failed', 'Email already exists!');
            }
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $email;
            $user->password = Hash::make($request->input('phone'));
            $user->save();
            $user->assignRole($request->user_role);


            $existingemail = Employee::where('email', $email)->exists();
            if ($existingemail) {
                return redirect()->route('employee.create')->with('failed', 'Email already exists!');
            }
            $data = $request->all();
            $data['user_id'] = $user->id;
            $date = Carbon::createFromFormat('m-d-Y', $request->input('join_date'));

            $month = $date->month;
            $year = $date->year;

            $data['join_date'] = $date;
            $data['join_month'] = $month;
            $data['join_year'] = $year;

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('admin/employee'), $imageName);
                $data['image'] = $imageName;
            }
            Employee::create($data);

            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Employee Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employee.index')->with('failed', 'Failed to create employee: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Employee::find($id);
        $positions = Designation::all();
        $companyId = getuser();

        if ($companyId) {
            $companies  = Company::where('id', $companyId)->get();
        } else {
            $companies  = Company::get();
        }

        $role_permissions   = Role::with('permissions')->get();

        return view('employee.edit', compact('member', 'positions', 'companies', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $employee = Employee::find($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:10',
            'company_id' => ['nullable', 'integer'],
            'image' => 'nullable|image',
            'designation_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user = User::where('id', $employee->user_id)->first();
            $email = $request->input('email');
            $existingemail = User::where('email', $email)->where('id', '!=', $user->id)->exists();
            if ($existingemail) {
                return back()->with('failed', 'Email already exists');
            }
            $user->name = $request->input('name');
            $user->email    = $email;
            $user->password = Hash::make($request->input('phone'));
            $user->save();

            if ($request->user_role) {
                $user->assignRole($request->user_role);
            }



            $existingemail = Employee::where('email', $email)->where('id', '!=', $employee->id)->exists();
            if ($existingemail) {
                return back()->with('failed', 'Email already exists');
            }
            $data = $request->all();
            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                $image_path = public_path("admin/employee/") . $employee->image;
                if (file_exists($image_path)) {
                    @unlink($image_path);
                }

                // Upload the new image and update the image name
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('admin/employee'), $imageName);
                $data['image'] = $imageName;
            }

            $employee->update($data);

            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Employee Updated Success');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employee.index')->with('failed', 'Failed to update employee: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $employee = Employee::find($id);
            $salaryrecordsid = SalaryRecord::where('employee_id', $employee->id)->exists();
            if ($salaryrecordsid) {
                return redirect()->route('employee.index')->with('failed', 'Employee has Salary Records. Cannot delete.');
            }
            $employee->delete();
            $user = User::where('id', $employee->user_id)->first();
            $user->delete();

            $image_path = public_path("admin/employee/") . $employee->image;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Employee Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('employee.index')->with('failed', 'Failed to delete employee: ' . $e->getMessage());
        }
    }
}
