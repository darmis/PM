<?php

namespace App\Http\Controllers;

use App\Calendar;
use Illuminate\Http\Request;

class CalendarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendars = Calendar::where('user_id', auth()->user()->id)->get();

        return view('calendar.index')
            ->with(compact('calendars'))
            ->with('name', 'Calendar');
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
            'description' => 'string|max:255',
            'date' => 'required|string|max:255'
        ]);

        $calendar = new Calendar;
        $calendar->name = $request->name;
        $calendar->description = $request->description;
        $calendar->date = $request->date;
        $calendar->user_id = auth()->user()->id;
        $calendar->save();

        return redirect('calendar')->with('success', 'Calendar entry created successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function updateCalendar(Request $request, Calendar $calendar)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'date' => 'required|string|max:255'
        ]);

        $calendar->name = $request->editName;
        $calendar->description = $request->editDescription;
        $calendar->date = $request->editDate;
        $calendar->save();

        return redirect('calendar')->with('success', 'Calendar entry updated successfully!');
    }

    public function updateDate(Request $request)
    {
        $calendar = Calendar::find($request->id);
        $calendar->date = $request->date;
        $calendar->save();

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function deleteCalendar(Calendar $calendar)
    {
        $calendar->delete();

        return redirect('calendar')->with('success', 'Calendar entry deleted successfully!');
    }
}
