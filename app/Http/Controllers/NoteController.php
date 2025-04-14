<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::with('workorder')->get();
        // dd($notes);
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'content' => 'required',
            'work_order_id' => 'required|exists:work_orders,id',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = '1';

        $data['show_to_vendor'] = $request->has('show_to_vendor') ? '1' : '0';
// dd($data);
        // Handle image uploads
        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image/workorder/note'), $imageName);
                $imageNames[] = $imageName;
            }
            $data['image'] = json_encode($imageNames); // Store images as JSON
        }
        // dd($data);
        Note::create($data);
        return redirect()->route('work-order.show', $request->work_order_id)->with('success', 'Comments Added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'content' => 'required',
            'status' => 'required',
        ]);
        // dd($request->all());

        //handel here image upload and update and old image delete 
        $data = $request->all();
        $data['user_id'] = auth()->id();

        // Handle image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            if ($note->image) {
                $images = json_decode($note->image);
                foreach ($images as $image) {
                    unlink(public_path('image/workorder/note/' . $image));
                }
            }
            // Upload new images
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image/workorder/note'), $imageName);
                $imageNames[] = $imageName;
            }
            $data['image'] = json_encode($imageNames); // Store images as JSON
        }
        $note->update($data);
        return back()->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('note.index')->with('success', 'Note deleted successfully.');
    }
}
