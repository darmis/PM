<?php

namespace App\Http\Controllers;

use App\Note;
use App\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function trackNote(Request $request){
        $notes = Note::where('user_id','=', auth()->user()->id)->first();

        $notes->note = $request->content;

        $notes->save();

        return;
    }
}
