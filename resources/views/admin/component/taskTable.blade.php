<!-- Task management section -->
<div class="container mt-4">
    <div class="tasks-section mt-5">
        <div class="d-flex justify-content-between">
            <h2>Tasks</h2>
            <div class="d-flex">
                <a href="{{ route('export.tasks.excel') }}" class="btn btn-secondary mb-3 mr-2">Export to Excel</a>
                <a href="{{ route('admin.component.createTask') }}" class="btn btn-primary mb-3 mr-2">Add Task</a>
            </div>
        </div>

        <!-- Tasks table -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Task</th>
                    <th scope="col">Description</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Sign</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->start_date }}</td>
                    <td>{{ $task->end_date }}</td>
                    <td>
                        @foreach ($task->users as $user)
                        @php
                        $submitStatus = $task->users()->wherePivot('user_id', $user->id)->wherePivot('submit', 1)->exists();
                        @endphp

                        <span style="background-color: {{ $submitStatus ? 'green' : 'red' }};" class="sign-style">{{ $user->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @php
                        $totalUsers = $task->users->count();
                        $submittedUsers = $task->users()->wherePivot('submit', 1)->count();
                        @endphp
                        @if ($submittedUsers == 0)
                        <div class="status-text" style="background-color: green;  color:white">
                            Open
                        </div>
                        @elseif ($submittedUsers == $totalUsers)
                        <div class="status-text" style="background-color: red; color: white;">
                            Closed
                        </div>
                        @else
                        <div class="status-text " style="background-color: orange; color: black;">
                            partial
                        </div>
                        @endif
                    </td>
                    <td class="d-flex justify-content-between">
                        <!-- Edit Button -->
                        <button class="btn btn-success w-50" style="margin-right: 9px;" data-target="#editTaskModal-{{ $task->id }}" data-toggle="modal">Edit</button>

                        <!-- Delete Button -->
                        <form id="deleteForm{{ $task->id }}" action="{{ route('task.destroy', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('{{ $task->id }}')" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @include('admin.component.editTaskModal', ['task' => $task, 'users' => $users])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
