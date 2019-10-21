<div class="modal fade" id="timingModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Enter comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="timingModalForm">
                    <div class="form-group">
                            <label for="timingNote">{{ __('Timing note') }}</label>
                            <textarea class="form-control note" id="timingNote" rows="3"></textarea>
                            </div>

                    <div class="form-group">
                        <label for="timingSelect">{{ __('Select task') }}</label>
                        <select class="form-control"  id="timingSelect">

                        </select>
                    </div>
                    <div class="form-group">
                            <button id="timingModalSubmit" type="button" class="btn color-o">{{ __('Save timing') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $.ajax({
            url: '{{ route("activeUserTasks") }}',
            type: 'get',
            success: function(data){
                $.each(data, function(id, task){
                    var option = new Option(task.name, task.id);
                    $(option).html(task.name);
                    $("#timingSelect").append(option);
                });
            }
        });
    });
</script>
