<div class="modal fade" id="calendarCreateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>{{ __('Create calendar entry') }}</h4>
                <form method="POST" action="{{ route('calendar.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-form-label text-md-right">{{ __('Description') }}</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-form-label text-md-right">{{ __('Date') }}</label><br>
                        <input id="date" type="text" class="form-control date @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>
                    </div>

                    <div class="col-md-12 text-center py-2">
                        <button type="submit" class="btn btn-dark px-4">
                            {{ __('Create') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
datepickr('.date', { dateFormat: 'Y-m-d'});
</script>
