<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Invoice;
use App\Project;
use App\Task;
use App\Timing;
use App\Client;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $invoices = Invoice::where('user_id', $user_id)
            ->where('trashed', false)->paginate(15);

        return view('invoices.all')
            ->with('invoices', $invoices)
            ->with('name','Your invoices');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        return view('invoices.create')
            ->with(compact('clients'));
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
            'client_id' => 'required',
            'projects' => 'required|array',
            'tasks' => 'array',
            'totalPrice' => 'required'
        ]);

        $filePath = '/invoices/invoice-'.Carbon::now()->setTimezone("Europe/Vilnius")->format('Y-m-d-His').'.pdf';

        $invoice = new Invoice;
        $invoice->client_id = $request->client_id;
        $invoice->user_id = auth()->user()->id;
        $invoice->path = 'storage'.$filePath;
        $invoice->projects = $request->projects;
        $invoice->tasks = $request->tasks;
        $invoice->price = $request->totalPrice;
        $invoice->time_spent = $request->totalTimeSpent;

        $invoice->save();

        $projects = Project::all();
        $tasks = Task::all();
        $pdf = app('dompdf.wrapper')->loadView('invoices.invoicePDF', ['invoice' => $invoice, 'projects' => $projects, 'tasks' => $tasks]);
        $content = $pdf->download()->getOriginalContent();
        Storage::put('public'.$filePath, $content);

        return redirect('invoice')->with('success', 'Invoice created successfully!');
    }

    /**
     * Change 'trash' boolean to true.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->trashed = 1;
        $invoice->save();

        return back()->with('success', 'Invoice deleted successfully!');
    }

    public function getClientProjects(Request $request){
        $projects = Project::where('client_id', $request->clientID)->get();
        return response()->json($projects);
    }

    public function getProjectTasks(Request $request){
        $tasks = Task::whereIn('project_id', $request->projectIDs)->get();
        return response()->json($tasks);
    }

    public function getSelectedTasksTime(Request $request){
        $start = Carbon::now();
        $end = Carbon::now();
        $timings = Timing::whereIn('task_id', $request->taskIDs)->get();
        foreach($timings as $timing){
            $times = explode(':',$timing->timespent,2);
            $end->addHours((int)$times[0])->addMinutes((int)$times[1]);
        }
        return $start->diffInHours($end) . ':' . $start->diff($end)->format('%I');
    }

    public function PDFview(Invoice $invoice){
        $projects = Project::all();
        $tasks = Task::all();
        return view('invoices.invoicePDF')->with(compact('invoice', 'projects', 'tasks'));
    }

    public function updatePayed(Request $request){

        $invoice = Invoice::find($request->activeID);
        $invoice->payed = $request->status;

        $invoice->save();

        return response()->json($invoice);
    }
}
