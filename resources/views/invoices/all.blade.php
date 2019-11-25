@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __($name) }}</div>

        <div class="card-body">
            <h3>
                @if(Auth::user()->isAdmin)
                    <div class="text-left"><a href="/invoice/create" class="btn btn-success btn-sm">{{ __('Create invoice') }}</a></div>
                @endif
            </h3>
            @if(count($invoices))
                <table class="table table-sm table-hover table-striped">
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Client') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Time spent') }}</th>
                        <th>{{ __('Payed') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td><a href="{{ url($invoice->path) }}" target="_blank">{{ $invoice->id }}</a></td>
                        <td><a href="{{ url('/client') }}/{{ $invoice->client->id }}">{{ $invoice->client->name }}</a></td>
                        <td>{{ $invoice->price }}</td>
                        <td>{{ $invoice->time_spent }}</td>
                        <td>
                            <select class="selectPayed" data-id="{{ $invoice->id }}">
                                <option value="1" {{ $invoice->payed == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{ $invoice->payed == 0 ? 'selected' : ''}}>No</option>
                            </select>
                        </td>
                        <td>
                            <div class="row">
                                <span><a href="{{ url($invoice->path) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></a></span>
                            @if(Auth::user()->isAdmin)
                                <span>
                                    <form method="POST" action="{{ url('/invoice') }}/{{ $invoice->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                </span>
                            @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{$invoices->links()}}
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.selectPayed').on('change', function(){
        var activeID = $(this).data('id');
        var status = $(this).val();
        $.ajax({
                url: '{{ route("updatePayed") }}',
                type: "post",
                data: {
                    activeID: activeID,
                    status: status
                }
        })
    });
});
</script>
@endsection
