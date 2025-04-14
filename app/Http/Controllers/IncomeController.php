<?php

namespace App\Http\Controllers;
use App\Models\Leads;
use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\IncomeExpence;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use App\Models\IncomeExpenceCategory;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes = IncomeExpence::where('type', '1')->get();
        return view('IncomeExpence.income.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = IncomeExpenceCategory::where('status', '1')->get();
        $leads = Leads::get();
        $methods = PaymentMethod::get();
        $projects = Project::get();
        return view('IncomeExpence.income.create', compact('projects', 'methods', 'leads', 'categories'));
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
            'income_expence_category_id' => 'required',
            'payment_method_id' => 'required',
            'date' => 'required|date',
            'income_amount' => 'required|numeric',
        ]);
        // dd($request->all());

        $date = date("Y-m-d", strtotime($request->input('date')));

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['date'] = $date;
        $input['type'] = 1; //1 means income & 2 means expence

        $income = IncomeExpence::create($input);

        if ($request->income_amount > 0) {

            $transaction = new Transaction([
                'user_id' => Auth::user()->id,
                'payment_method_id' => $request->payment_method_id,
                'receive_amount' => $request->income_amount,
                'type' => '0', //0 means receive 1 means sent amount
                'transaction_type' => 'App\Models\IncomeExpence',
                'transaction_date' => now(),
                'reference' => $request->reference,
            ]);
            $income->transactions()->save($transaction);
        }

        return redirect()->route('income.index')->with("success", 'Income created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income = IncomeExpence::find($id);
        $income->delete();
        return redirect()->route('expence.index')->with("success", 'Income Deleted successfully.');
    }
}
