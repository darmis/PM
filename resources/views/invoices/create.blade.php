@extends('layouts.app')

@section('content')
<div class="justify-content-center">
    <div class="card">
        <div class="card-header text-center text-uppercase">{{ __('Create invoice') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('invoice.store') }}">
                @csrf
                <div class="row px-2">
                    <div class="col-md-6 px-3">
                        <div class="row">
                            <label for="client" class="col-form-label text-md-right">{{ __('Client') }}</label>
                            <select id="client" name="client_id" class="form-control @error('client') is-invalid @enderror">
                                <option value="" default>{{ __('Select client') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>

                            <label for="project" class="col-form-label text-md-right">{{ __('Projects') }}</label>
                            <select id="project" name="projects[]" class="form-control @error('project') is-invalid @enderror" multiple>
                                    <option value="" default>{{ __('Select projects') }}</option>
                            </select>

                            <label for="task" class="col-form-label text-md-right">{{ __('Tasks') }}</label>
                            <select id="task" name="tasks[]" class="form-control @error('task') is-invalid @enderror" multiple>
                                    <option value="">{{ __('Select tasks') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 px-3">
                        <label for="totalTimeSpent" class="col-form-label text-md-right">{{ __('Total time spent') }}</label><br>
                        <input id="totalTimeSpent" type="text" class="form-control @error('totalTimeSpent') is-invalid @enderror" name="totalTimeSpent" value="{{ old('totalTimeSpent') }}" autocomplete="totalTimeSpent">

                        <label for="pricePerHour" class="col-form-label text-md-right">{{ __('Price per hour') }}</label><br>
                        <input id="pricePerHour" type="text" class="form-control @error('pricePerHour') is-invalid @enderror" name="pricePerHour" value="{{ old('pricePerHour') }}" autocomplete="pricePerHour">

                        <label for="totalPrice" class="col-form-label text-md-right">{{ __('Total price') }}</label><br>
                        <input id="totalPrice" type="text" class="form-control @error('totalPrice') is-invalid @enderror" name="totalPrice" value="{{ old('totalPrice') }}" required autocomplete="totalPrice">
                    </div>
                </div>

                <div class="col-md-12 text-center py-2">
                    <button type="submit" class="btn btn-dark px-4">
                        {{ __('Create') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
        document.addEventListener("DOMContentLoaded", function(event) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#client').change(function(){
                if($(this).val() != ''){
                    var clientID = $(this).val();
                    $.ajax({
                        url: '{{ route("getClientProjects") }}',
                        type: 'post',
                        data: {
                            clientID: clientID
                        },
                        success: function(data){
                            $("#project").empty();
                            $.each(data, function(id, project){
                                var option = new Option(project.name, project.id);
                                $(option).html(project.name);
                                $("#project").append(option);
                            });
                        }
                    });
                }
            });

            $('#project').change(function(){
                if($(this).val() != ''){
                    var projectIDs = $(this).val();
                    $.ajax({
                        url: '{{ route("getProjectTasks") }}',
                        type: 'post',
                        data: {
                            projectIDs: projectIDs
                        },
                        success: function(data){
                            $("#task").empty();
                            $.each(data, function(id, project){
                                var option = new Option(project.name, project.id);
                                $(option).html(project.name);
                                $("#task").append(option);
                            });
                        }
                    });
                }
            });

            $('#task').change(function(){
                if($(this).val() != ''){
                    var taskIDs = $(this).val();
                    $.ajax({
                        url: '{{ route("getSelectedTasksTime") }}',
                        type: 'post',
                        data: {
                            taskIDs: taskIDs
                        },
                        success: function(data){
                            $("#totalTimeSpent").attr('value', data);
                            if($("#totalTimeSpent").val() != '' && $("#pricePerHour").val() != ''){
                                var pricePerHour = $("#pricePerHour").val();
                                var timeArray = data.split(':');
                                var totalPrice = timeArray[0] * pricePerHour + timeArray[1] / 60 * pricePerHour;
                                $("#totalPrice").attr('value', totalPrice.toFixed(2));
                            }
                        }
                    });
                }
            });



        });
    </script>
@endsection
