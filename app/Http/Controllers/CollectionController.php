<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Collection;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = Collection::all();
        return view('project.collection.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::get();
        $methods = PaymentMethod::all();

        return view('project.collection.create', compact('projects', 'methods'));
    }

    public function getCollectedAmount(Request $request)
    {
        $projectId = $request->input('project_id');

        $collectedAmount = Collection::where('project_id', $projectId)->sum('amount');

        return response()->json(['collectedAmount' => $collectedAmount]);
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
            'project_id' => 'required',
            'payment_method_id' => 'required',
            'amount' => 'required|required',
            'date' => 'required|date',
        ]);
        // dd($request->all());

        $due = $request->due_amount;
        $amount = $request->amount;
        if ($due < $amount) {
            return redirect()->back()->with('failed', 'Inter valid Amount');
        }


        $date = date("Y-m-d", strtotime($request->input('date')));

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['date'] = $date;

        $collection = Collection::create($input);

        if ($request->amount > 0) {

            $transaction = new Transaction([
                'user_id' => Auth::user()->id,
                'payment_method_id' => $request->payment_method_id,
                'receive_amount' => $request->amount,
                'type' => '0', //0 means receive 1 means sent amount
                'transaction_type' => 'App\Models\Collection',
                'transaction_date' => now(),
                'reference' => $request->reference,
                'note' => $request->note,
            ]);
            $collection->transactions()->save($transaction);
        }

        return redirect()->back()->with("success", 'Collection created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collection = Collection::find($id);
        $collection->delete();
        return redirect()->route('collection.index')->with('success', 'colleciton Delete Successfully');
    }
}
