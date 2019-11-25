<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #123</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-size: x-small;
        }

        .bold {
            font-weight: bold;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #F89600;
            color: #2E3A46;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
        .border-bottom {
            border-bottom: 1px solid grey;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 40%;">
            <h3>{{ $invoice->client->name }}</h3>
                <pre>
{{ $invoice->client->address }}
{{ $invoice->client->phone }}
{{ $invoice->client->email }}
<br />
Date: {{ Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}
</pre>


            </td>
            <td align="center">
                {{-- @if()
                    <img src="/path/to/logo.png" alt="Logo" width="64" class="logo"/>
                @endif --}}
                {{-- logo place --}}
            </td>
            <td align="right" style="width: 40%;">

                <h3>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</h3>
                {{-- if company not set --}}
                <pre>
                    settings->address
                    settings->phone
                    settings->email
                    settings->www
                </pre>
            </td>
        </tr>

    </table>
</div>


<br/>

<div class="invoice">
    <h3>Invoice #{{ $invoice->id }}</h3>
    <table width="100%">
        <thead>
        <tr>
            <th colspan="3" align="center">Description</th>
        </tr>
        </thead>
        <tbody>

        @foreach($invoice->projects as $projectId)
            <tr>
                <td colspan="3"><span class="border-bottom">    Project - {{ $projects->find($projectId)->name }}</span></td>
            </tr>
            @if(isset($invoice->tasks))
                @foreach($invoice->tasks as $taskId)
                    @if($tasks->find($taskId)->project->id == $projects->find($projectId)->id )
                        <tr>
                            <td colspan="3"><span class="border-bottom">        - Task - {{ $tasks->find($taskId)->name }}</span></td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach

        <tr>
            <td colspan="3">
                <br>
                <br>
                <br>
            </td>
        </tr>
        </tbody>



        <tfoot>
        @if(isset($invoice->time_spent) && $invoice->time_spent != '0:00')
        <tr>
            <td colspan="2" align="right">Total time spent:</td>
            <td align="left" class="gray bold">{{ $invoice->time_spent }}</td>
        </tr>
        @endif
        <tr>
            <td  colspan="2" align="right">Total price:</td>
            <td align="left" class="gray bold">€{{ $invoice->price }}</td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved.
            </td>
            <td align="right" style="width: 50%;">
                settings->company
            </td>
        </tr>

    </table>
</div>
</body>
</html>
