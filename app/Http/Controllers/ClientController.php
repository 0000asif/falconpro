<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Client;
use App\Models\Company;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    protected $companyId;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->companyId = getuser();

        if($this->companyId){
            $companyId  = $this->companyId;
        }else{
            $companyId  = $request->get('company_id');
        }

        if ($companyId) {
            $clients = Client::where('company_id', $companyId)->get();
            $companies = Company::where('id', $companyId)->get();
        }else{
            $clients = Client::all();
            $companies = Company::all();
        }

        return view('client.index', compact('clients', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $companyId = getuser();

        if($companyId){
            $companies = Company::where('status', '1')->where('id', $companyId)->get();
        }else{
            $companies = Company::where('status', '1')->get();
        }

        return view('client.create', compact('companies'));
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
            'email' => ['required', 'email', 'max:255', 'unique:clients,email'],
            'company_id' => ['nullable', 'integer'],
            'address' => ['required', 'string', 'max:255'],
            'city_id' => ['nullable', 'string', 'max:255'],
            'state_id' => ['required', 'string', 'max:255'],
            'zip_code' => ['required'],
            'status' => ['required', 'boolean'],
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        Client::create($data);
        return redirect()->route('client.index')->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $companyId = getuser();
        if($companyId){
            $companies = Company::where('id', $companyId)->get();
        } else{
            $companies = Company::get();
        }

        return view('client.edit', compact('client',  'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email', 'max:255', 'unique:clients,email,' . $client->id],
            'company_id' => ['nullable', 'integer'],
            'address' => ['required', 'string', 'max:255'],
            'city_id' => ['nullable', 'string', 'max:255'],
            'state_id' => ['required', 'string', 'max:255'],
            'zip_code' => ['required'],
            'status' => ['required', 'boolean'],
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $client->update($data);
        return redirect()->route('client.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $workorderid = WorkOrder::where('client_id', $client->id)->exists();
        if ($workorderid) {
            return redirect()->route('client.index')->with('failed', 'Client cannot be deleted as it has associated work orders.');
        }
        $client->delete();
        return redirect()->route('client.index')->with('success', 'Client deleted successfully.');
    }
}
