<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\Client;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(15);
        $users = User::all(['id', 'name', 'lastname']);

        return view('projects.all')
            ->with('projects', $projects)
            ->with('users', $users)
            ->with('name', 'All projects list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all(['id', 'name', 'lastname']);
        $clients = Client::all(['id', 'name']);
        return view('projects.create')
            ->with(compact('users', 'clients'));
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

        $project = new Project;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->startdate = $request->startdate;
        $project->deadline = $request->deadline;
        $project->status = $request->status;
        $project->members = $request->members;
        $project->creator = auth()->user()->id;
        $project->client_id = $request->client_id;

        $project->save();

        return redirect('project')->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $creator = User::where('id', $project->creator)->first(['id', 'name', 'lastname']);
        $members = User::whereIn('id', $project->members)->get(['id', 'name', 'lastname']);

        return view('projects.show')->with(compact('project', 'creator', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $users = User::all(['id', 'name', 'lastname']);
        $clients = Client::all(['id', 'name']);
        return view('projects.edit')->with(compact('project', 'users', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'startdate' => 'string|max:255',
            'deadline' => 'string|max:255',
            'status' => 'string|max:255',
            'members' => 'required'
        ]);

        $update = request()->all();
        $project->update($update);

        return redirect('project')->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Project deleted successfully!');
    }

    public function activeUserProjects()
    {
        $projects = Project::whereJsonContains('members', (string) auth()->user()->id)->paginate(15);
        $users = User::all(['id', 'name', 'lastname']);

        return view('projects.myprojects')
            ->with('projects', $projects)
            ->with('users', $users)
            ->with('name', 'My projects');
    }
}
