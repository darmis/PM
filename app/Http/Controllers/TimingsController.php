<?php

namespace App\Http\Controllers;

use App\Timing;
use App\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $timings = Timing::where('user_id','=',$user_id)
            ->where('project_id', '>', '0')
            ->where('task_id', '>', '0')
            ->orderBy('updated_at', 'DESC')->paginate(15);

        return view('timings.all')
            ->with('timings', $timings)
            ->with('name','Your timings');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Timing  $timing
     * @return \Illuminate\Http\Response
     */
    public function show(Timing $timing)
    {
        return view('timings.show')
            ->with('timing', $timing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Timing  $timing
     * @return \Illuminate\Http\Response
     */
    public function edit(Timing $timing)
    {
        $tasks = Task::whereJsonContains('members', (string) auth()->user()->id)->get(['id', 'name']);
        return view('timings.edit')->with(compact('timing', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Timing  $timing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timing $timing)
    {
        $this->validate($request, [
            'note' => 'required|string',
            'task_id' => 'required'
        ]);

        $update = request()->all();
        $timing->update($update);

        return redirect('timing')->with('success', 'Timing updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Timing  $timing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timing $timing)
    {
        $timing->delete();

        return view('timings.all')->with('success', 'Timing removed');
    }

    public function addClockIn(Request $request){
        $timing = new Timing;
        $timing->start_time = Carbon::now()->setTimezone("Europe/Vilnius");
        $timing->user_id = auth()->user()->id;
        $timing->task_id = 0;
        $timing->project_id = 0;
        $timing->end_time = Carbon::now()->setTimezone("Europe/Vilnius");
        $timing->timespent = '00:00:00';
        $timing->note = '';

        $timing->save();

        return response()->json($timing->id)
            ->withCookie(cookie()->forever('start_time', $timing->start_time))
            ->withCookie(cookie()->forever('active_id', $timing->id));
    }

    public function addClockOut(Request $request){

        $timing = Timing::find(\Cookie::get('active_id'));
        $timing->end_time = Carbon::now()->setTimezone("Europe/Vilnius");
        $timing->note = $request->note;
        $timing->user_id = auth()->user()->id;
        $timing->task_id = $request->taskID;
        $task = Task::find($request->taskID);
        $proj_id = $task->project_id;
        $timing->project_id = $proj_id;

        $start = new Carbon($timing->start_time);
        $end = new Carbon($timing->end_time);
        $timing->timespent = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');

        $timing->save();

        $cookieTime = \Cookie::forget('start_time');
        $cookieId = \Cookie::forget('active_id');

        return response()->json($timing->id)->withCookie($cookieTime)->withCookie($cookieId);
    }
}
