<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::whereJsonContains('members', (string) auth()->user()->id)
            ->orderBy('updated_at', 'DESC')->paginate(15);
        $users = User::all(['id', 'name', 'lastname']);

        return view('tasks.all')
            ->with('tasks', $tasks)
            ->with('users', $users)
            ->with('name', 'All tasks list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all(['id', 'name', 'lastname']);
        $projects = Project::all(['id', 'name']);

        return view('tasks.create')
            ->with(compact('users', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'startdate' => 'string|max:255',
            'deadline' => 'string|max:255',
            'status' => 'string|max:255',
            'members' => 'required'
        ]);

        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->startdate = $request->startdate;
        $task->deadline = $request->deadline;
        $task->status = $request->status;
        $task->members = $request->members;
        $task->creator = auth()->user()->id;
        $task->project_id = $request->project_id;

        $task->save();

        return redirect('task')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $creator = User::where('id', $task->creator)->first(['id', 'name', 'lastname']);
        $members = User::whereIn('id', $task->members)->get(['id', 'name', 'lastname']);

        return view('tasks.show')->with(compact('task', 'creator', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $users = User::all(['id', 'name', 'lastname']);
        $projects = Project::all(['id', 'name']);
        return view('tasks.edit')->with(compact('task', 'users', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'startdate' => 'string|max:255',
            'deadline' => 'string|max:255',
            'status' => 'string|max:255',
            'members' => 'required'
        ]);

        $update = request()->all();
        $task->update($update);

        return redirect('task')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted successfully!');
    }

    public function activeUserOpenTasks()
    {
        $tasks = Task::whereJsonContains('members', (string) auth()->user()->id)
            ->where('status', '=', 'Not started yet')
            ->orWhere('status', '=', 'In progress')->paginate(15);
        $users = User::all(['id', 'name', 'lastname']);

        return view('tasks.myopentasks')
            ->with('tasks', $tasks)
            ->with('users', $users)
            ->with('name', 'My open tasks');
    }

    public function loadingTasks()
    {
        $data = Task::whereJsonContains('members', (string) auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        return response()->json($data);
    }

    public function activeUserTasks() {
        $data = Task::whereJsonContains('members', (string) auth()->user()->id)->get(['id', 'name'])->toArray();
        return response()->json($data);
    }

    public function updateStatus(Request $request){
        $task = Task::find($request->taskID);
        if($request->newStatus == '_notstarted'){
            $task->status = 'Not started yet';
        } else if($request->newStatus == '_progress') {
            $task->status = 'In progress';
        } else if($request->newStatus == '_done'){
            $task->status = 'Done';
        }
        $task->save();

        return;
    }
}
