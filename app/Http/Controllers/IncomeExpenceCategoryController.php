<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IncomeExpenceCategory;

class IncomeExpenceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = IncomeExpenceCategory::all();
        return view('IncomeExpence.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('IncomeExpence.category.create');
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
            'name' => 'required|unique:income_expence_categories,name|max:255',
            'status' => 'required'
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        IncomeExpenceCategory::create($data);
        return redirect()->route('IEcategory.create')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncomeExpenceCategory  $incomeExpenceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeExpenceCategory $incomeExpenceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncomeExpenceCategory  $incomeExpenceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = IncomeExpenceCategory::find($id);
        return view('IncomeExpence.category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeExpenceCategory  $incomeExpenceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        $data = $request->all();
        $category = IncomeExpenceCategory::find($id);


        $category->update($data);

        return redirect()->route('IEcategory.index')->with('success', 'Category Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncomeExpenceCategory  $incomeExpenceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = IncomeExpenceCategory::find($id);

        $isUsed = $category->whereHas('income_expences', function ($query) use ($id) {
            $query->where('income_expence_category_id', $id);
        })->exists();

        if ($isUsed) {
            return redirect()->route('IEcategory.index')->with('failed', 'Category cannot be deleted as it is used in Income/Expense records.');
        }

        $category->delete();
        return redirect()->route('IEcategory.index')->with('success', 'Category Deleted successfully.');
    }
}
