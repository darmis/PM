<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\User;
use App\Task;
use App\Project;
use App\Client;
use App\Timing;
use App\Invoice;
use App\Note;
use App\Calendar;
use App\Todo;

class DashboardController extends Controller
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
        $user = auth()->user()->id;
        $myProjectsCount = Project::whereJsonContains('members', (string) $user)->count();
        $myOpenTasksCount = Task::whereJsonContains('members', (string) $user)
            ->where('status', '=', 'Not started yet')
            ->orWhere('status', '=', 'In progress')->count();
        $totalProjectsCount = Project::whereJsonContains('members', (string) $user)->count();
        $totalTasksCount = Task::whereJsonContains('members', (string) $user)->count();
        $totalClientsCount = Client::all()->count();

        $start = Carbon::now();
        $end = Carbon::now();
        $timings = Timing::where('user_id', $user)->get();
        foreach($timings as $timing){
            $times = explode(':',$timing->timespent,2);
            $end->addHours((int)$times[0])->addMinutes((int)$times[1]);
        }
        $totalTimings = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I');

        $totalTimingsCount = Timing::where('user_id', $user)->count();

        $totalInvoicesCount = Invoice::where('user_id', $user)->count();

        $tasksForTimeline = Task::whereJsonContains('members', (string) $user)->get();

        $todayCalendars = Calendar::where('user_id', $user)
            ->whereDate('date', '=', Carbon::today()->toDateString())->limit(3)->get();
        $note = Note::where('user_id', $user)->first();
        $todos = Todo::where('user_id', $user)->get();

        $chart_options = [
            'chart_title' => 'Tasks progress',
            'report_type' => 'group_by_string',
            'model' => 'App\Task',
            'group_by_field' => 'status',
            'chart_type' => 'pie',
        ];

        $chart = new LaravelChart($chart_options);

        return view('dashboard')
            ->with(compact(
                'myProjectsCount', 'myOpenTasksCount',
                'totalProjectsCount', 'totalTasksCount',
                'totalClientsCount', 'totalTimingsCount',
                'tasksForTimeline', 'note',
                'todayCalendars', 'todos',
                'chart', 'totalTimings',
                'totalInvoicesCount'
            ));
    }
}
