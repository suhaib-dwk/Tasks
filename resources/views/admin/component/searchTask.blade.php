<div class="modal fade" id="searchTask" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Task Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="taskModalBody">
            @foreach ($tasks as $task)
    <div class="card">
        <div class="card-header">{{ $task->title }}</div>
        <div class="card-body">
            <p>{{ $task->description }}</p>
            <p>Start Date: {{ $task->start_date }}</p>
            <p>End Date: {{ $task->end_date }}</p>
        </div>
    </div>
@endforeach
            </div>
        </div>
    </div>
</div>
