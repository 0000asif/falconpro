<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leads = Leads::all();
        $employees = Employee::all(); // Fetch all employees
        return view('service.create', compact('employees', 'leads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'charge' => 'required|numeric',
            'start_date' => 'required|date',
            'complete_date' => 'required',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        // dd($request->all());

        $startDate = date("Y-m-d", strtotime($request->input('start_date')));

        // Prepare the input data
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['start_date'] = $startDate;
        $input['status'] = 0; //0:means pending, 1:means Done

        Service::create($input);

        // Redirect back with success message
        return redirect()->route('service.index')->with('success', 'Service created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch the task by ID
        $task = Service::findOrFail($id);

        // Return a view with task details
        return view('service.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the salary record by ID or throw a 404 if not found
        $task = Service::findOrFail($id);

        // Fetch related data
        $leads = Leads::all(); // Assuming you have a Lead model
        $employees = Employee::all(); // Assuming you have an Employee model

        // Return the edit view with salary record and additional data
        return view('service.edit', compact('task', 'leads', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'charge' => 'required|numeric',
            'start_date' => 'required|date',
            'complete_date' => 'required',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        // Find the task by ID
        $task = Service::findOrFail($id);

        // Format dates
        $startDate = date("Y-m-d", strtotime($request->input('start_date')));

        $input = $request->all();
        $input['start_date'] = $startDate;

        // Update task fields
        $task->update($input);

        // Redirect back with success message
        return redirect()->route('service.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collection = Service::find($id);
        $collection->delete();
        return redirect()->route('service.index')->with('success', 'colleciton Delete Successfully');
    }
}
