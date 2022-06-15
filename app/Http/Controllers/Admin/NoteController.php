<?php

namespace App\Http\Controllers\Admin;

use App\ChangeOrder;
use App\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $note = new Note();
        $notes = $note
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $note_count = $note->all()->count();

        return view(\request()->route()->getName())->with([
            'notes' => $notes,
            'note_count' => $note_count
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(\request()->route()->getName());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = 1 /*auth()->user()->id*/
        ;

        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|string',
            'description' => 'required|string|max:255',
        ]);

        $note = new Note();
        $note->title = $request->input('title');
        $note->user_id = $user_id;
        $note->date = $request->input('date');
        $note->description = $request->input('description');
        $note->save();

        alert()->success('با موفقیت ثبت شد.');

        return redirect(route('admin.notes.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        $note->update([
            'view' => 1
        ]);
        return view(\request()->route()->getName())->with([
            'note' => $note
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|string',
            'description' => 'required|string|max:255',
        ]);

        $note->title = $request->input('title');
        $note->date = $request->input('date');
        $note->description = $request->input('description');
        $note->save();

        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.notes.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        try {
            $note->delete();
            alert()->success('با موفقیت حذف شد!');
            return redirect(route('admin.notes.index'));
        } catch (\Exception $e) {
        }

    }
}
