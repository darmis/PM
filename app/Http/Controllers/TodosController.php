<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodosController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'todo' => 'required|string|max:90'
        ]);

        $todo = new Todo;
        $todo->user_id = auth()->user()->id;
        $todo->todo = $request->todo;

        $todo->save();

        return redirect()->back();
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->back();
    }
}
