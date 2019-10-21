<div class="modal fade" id="calendarEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>{{ __('Edit calendar entry') }}</h4>
                <form method="POST" action="{{ url('/calendar') }}/updateCalendar">
                    @csrf
                    <input type="text" name="id" value="" class="hidden">
                    <div class="form-group">
                        <label for="editName" class="col-form-label text-md-right">{{ __('Name') }}</label>
                        <input id="editName" type="text" class="form-control @error('editName') is-invalid @enderror" name="editName" value="{{ old('editName') }}" required autocomplete="editName" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="editDescription" class="col-form-label text-md-right">{{ __('Description') }}</label>
                        <textarea id="editDescription" class="form-control @error('editDescription') is-invalid @enderror" name="editDescription" rows="3">{{ old('editDescription') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for=editDate" class="col-form-label text-md-right">{{ __('Date') }}</label><br>
                        <input id="editDate" type="text" class="form-control date @error('editDate') is-invalid @enderror" name="editDate" value="{{ old('editDate') }}" required autocomplete="editDate" autofocus>
                    </div>
                    <div class="row mx-2">
                        <div class="py-2 mx-2">
                            <button type="submit" class="btn btn-dark px-4">
                                {{ __('Update') }}
                            </button>
                        </div>
                        <form method="POST" action="{{ url('/calendar') }}/deleteCalendar">
                            @csrf
                            <input type="text" name="id" value="" class="hidden">
                            <div class="py-2 mx-2">
                                <button type="submit" class="btn btn-danger px-4">
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>


<script>
datepickr('.date', { dateFormat: 'Y-m-d'});
</script>
