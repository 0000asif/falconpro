<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Transaction;
use App\Models\SalaryRecord;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class SalaryRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $companyId = getuser();

        $query  = SalaryRecord::with('staff', 'paymentmethod');

        if ($companyId) {
            $query->whereHas('staff', function ($q) use ($companyId) {
                $q->where('company_id', $companyId);
            });
        }

        $salaries = $query->get();

        return view('salaries.index', compact('salaries'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyId = getuser();
        if ($companyId) {
            $staff      = Employee::where('company_id', $companyId)->get();
        } else {
            $staff      = Employee::get();
        }
        $methods    = PaymentMethod::all();
        return view('salaries.create', compact('staff', 'methods'));
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
            'employee_id' => 'required',
            'payment_method_id' => 'required',
            'payment_year' => 'required',
            'payment_month' => 'required',
            'salary_amount' => 'required',
            'payment_date' => 'required',
            'bonous' => 'nullable',
            'note' => 'nullable',
        ]);


        $date = Carbon::createFromFormat('m-d-Y', $request->payment_date)->format('Y-m-d');

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['payment_date'] = $date;
        $input['status'] = 1;
        $salary = SalaryRecord::create($input);


        if ($request->salary_amount > 0) {

            $transaction = new Transaction([
                'user_id' => Auth::user()->id,
                'payment_method_id' => $request->payment_method_id,
                'sent_amount' => $request->salary_amount,
                'type' => '1', //0 means receive 1 means sent amount
                'transaction_type' => 'App\Models\SalaryRecord',
                'transaction_date' => now(),
                'note' => $request->note,
            ]);
            $salary->transactions()->save($transaction);
        }

        return redirect()->route('salary.index')->with("success", 'Collection created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalaryRecord  $salaryRecord
     * @return \Illuminate\Http\Response
     */
    public function show(SalaryRecord $salaryRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalaryRecord  $salaryRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(SalaryRecord $salaryRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalaryRecord  $salaryRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalaryRecord $salaryRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalaryRecord  $salaryRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalaryRecord $salaryRecord)
    {
        //
    }
}
