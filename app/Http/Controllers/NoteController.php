<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __saveNote($contact_id){
        if ($contact_id == null){
            return redirect()->back()->with('error','Contact not found');
        }
        $user = auth()->user();
        $note = new Note();
        $note->user_id = $user->id;
        $note->contact_id = $contact_id;
        $note->note = \request('note');
        $note->status = 1;
        $note->save();
        return redirect("contact/update/$contact_id");
    }
}
