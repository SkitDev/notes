<?php

namespace App\Http\Controllers;

use App\Note;
use App\Notifications\NoteAdded;
use App\Notifications\NoteDeleted;
use App\Notifications\NoteUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth::user()->id)->paginate(5);
        return view('notes.index', ['notes' => $notes]);
    }

    public function show($id)
    {
        $note = Note::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if($note == null){
            return redirect()->route('notes.index')->with('error', 'This note doesn\'t exist or doesn\'t belong to you !');
        }
        return view('notes.show', ['note' => $note]);
    }

    public function add()
    {
        return view('notes.add');
    }
    public function edit($id)
    {
        $note = Note::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if($note == null){
            return redirect()->route('notes.index')->with('error', 'This note doesn\'t exist or doesn\'t belong to you !');
        }
        return view('notes.edit', ['note' => $note]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'note' => 'required',
        ]);
        $note = new Note();
        $note->title = $validator['title'];
        $note->note = $validator['note'];
        $note->user_id = Auth::user()->id;
        if($note->save()){
            Auth::user()->notify(new NoteAdded($note));
            return redirect()->route('notes.index')->with('success', 'Your note has been added !');
        }else {
            return redirect()->route('notes.index')->with('error', 'Failed to add your note !');
        }


    }
    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'title' => 'required|max:255',
            'note' => 'required',
        ]);
        $note = Note::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if($note == null){
            return redirect()->route('notes.index')->with('error', 'This note doesn\'t exist or doesn\'t belong to you !');
        }
        $note->title = $validator['title'];
        $note->note = $validator['note'];
        $note->user_id = Auth::user()->id;
        if($note->save()){
            Auth::user()->notify(new NoteUpdated($note));
            return redirect()->route('notes.index')->with('success', 'Your note has been updated !');
        }else {
            return redirect()->route('notes.index')->with('error', 'Failed to add your note !');
        }

    }
    public function destroy($id)
    {
        $note = Note::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if($note == null){
            return redirect()->route('notes.index')->with('error', 'This note doesn\'t exist or doesn\'t belong to you !');
        }
        if($note->delete()){
            Auth::user()->notify(new NoteDeleted($note));
            return redirect()->route('notes.index')->with('success', 'Your note has been deleted !');
        }else {
            return redirect()->route('notes.index')->with('error', 'Failed to delete your note !');
        }
    }
}
