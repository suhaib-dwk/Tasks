<div class="modal fade" id="viewTaskModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTaskModalLabel">View Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Task Details</h5>
                <p><strong>Title:</strong> {{ $task->title }}</p>
                <p><strong>Description:</strong> {{ $task->description }}</p>
                <p><strong>Start Date:</strong> {{ $task->start_date }}</p>
                <p><strong>End Date:</strong> {{ $task->end_date }}</p>

                <h5>Assigned Users and Submission Time</h5>
                <ul class="list-group">
    @foreach ($task->users as $user)
        @php
            $submitStatus = $task->users()->wherePivot('user_id', $user->id)->wherePivot('submit', 1)->exists();
            $submittedAt = $task->users()->wherePivot('user_id', $user->id)->value('submitted_at');
        @endphp
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <span>{{ $user->name }}</span>
                @if ($submitStatus)
                    <span class="badge badge-success">Submitted at: {{ $submittedAt }}</span>
                @else
                    <span class="badge badge-danger">Not Submitted</span>
                @endif
            </div>
        </li>
    @endforeach
</ul>

                <div>
                    Status: @php
                    $totalUsers = $task->users->count();
                    $submittedUsers = $task->users()->wherePivot('submit', 1)->count();
                    @endphp
                    @if ($submittedUsers == 0)
                    <div class="badge badge-success" >
                        Open
                    </div>
                    @elseif ($submittedUsers == $totalUsers)
                    <div class="badge badge-danger" >
                        Closed
                    </div>
                    @else
                    <div class="badge badge-orange" style="background-color: orange; color: black;">
                        partial
                    </div>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
