<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Expertise;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Expertise::all();
        return view('expertise.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expertise.create');
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
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        Expertise::create($data);
        return redirect()->route('expertise.index')->with('success', 'Expertise created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function show(Expertise $expertise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function edit(Expertise $expertise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expertise $expertise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expertise $expertise)
    {
        $vendors = Vendor::where('expertise_id', $expertise->id)->get();
        if ($vendors->count() > 0) {
            return redirect()->route('expertise.index')->with('failed', 'Expertise is used in vendor table, cannot delete it.');
        }
        $expertise->delete();
        return redirect()->route('expertise.index')->with('success', 'Expertise deleted successfully.');
    }
}
