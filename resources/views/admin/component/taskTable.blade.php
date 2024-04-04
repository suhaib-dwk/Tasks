<div class="container mt-4">
        <div class="tasks-section mt-5">
            <div class="d-flex justify-content-between">
                <h2>Tasks</h2>
                <div class="d-flex">
                    <a href="{{ route('export.tasks.excel') }}" class="btn btn-secondary mb-3 mr-2"><i class="fas fa-table"></i></a>
                    <a href="{{ route('admin.component.createTask') }}" class="btn btn-primary mb-3 mr-2"><i class="fas fa-plus"></i></a>
                </div>
            </div>



            <!-- Tasks table -->
            <table class="table" id="tasks-table">
                <thead>
                    <tr>
                        <th scope="col" class="filter-column" data-column="title">Task <span class="sort-arrow"></span></th>
                        <th scope="col" class="filter-column" data-column="description">Description <span class="sort-arrow"></span></th>
                        <th scope="col" class="filter-column" data-column="start_date">Start Date <span class="sort-arrow"></span></th>
                        <th scope="col" class="filter-column" data-column="end_date">End Date <span class="sort-arrow"></span></th>
                        <th scope="col">Assign</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>


                @foreach($tasks  as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->start_date }}</td>
                        <td>{{ $task->end_date }}</td>
                        <td>
                            @foreach ($task->users as $user)
                            @php
                            $submitStatus = $task->users()->wherePivot('user_id', $user->id)->wherePivot('submit', 1)->exists();
                            @endphp

                            <span style="background-color: {{ $submitStatus ? 'green' : 'red' }};" class="sign-style badge badge-success">{{ $user->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @php
                            $totalUsers = $task->users->count();
                            $submittedUsers = $task->users()->wherePivot('submit', 1)->count();
                            @endphp
                            @if ($submittedUsers == 0)
                            <div class="status-text badge badge-success" >
                                Open
                            </div>
                            @elseif ($submittedUsers == $totalUsers)
                            <div class="status-text badge badge-danger" >
                                Closed
                            </div>
                            @else
                            <div class="status-text badge badge-warning" >
                                partial
                            </div>
                            @endif
                        </td>
                        <td class="d-flex justify-content-around align-content-center flex-wrap">
                            <button class="btn btn-dark " style="margin-right: 9px;" data-target="#viewTaskModal-{{ $task->id }}" data-toggle="modal"><i class="fas fa-info"></i></button>


                            <!-- Edit Button -->
                            <button class="btn btn-success "  data-target="#editTaskModal-{{ $task->id }}" data-toggle="modal"><i class="fa fa-edit" ></i>
</button>

                            <!-- Delete Button -->
                            <form id="deleteForm{{ $task->id }}" action="{{ route('task.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $task->id }}')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @include('admin.component.editTaskModal', ['task' => $task, 'users' => $users])
                    @include('admin.component.viewTaskModal', ['task' => $task, 'users' => $users])
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
    <ul class="pagination">
        @if ($tasks->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $tasks->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a>
            </li>
        @endif

        @php
            // Calculate the starting page number
            $startPage = $tasks->currentPage() > 9 ? $tasks->currentPage() - 9 : 1;
        @endphp

        @for ($i = $startPage; $i <= $tasks->lastPage(); $i++)
            @if ($i == $tasks->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $i }}</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $tasks->url($i) }}" class="page-link">{{ $i }}</a>
                </li>
            @endif
        @endfor

        @if ($tasks->hasMorePages())
            <li class="page-item">
                <a href="{{ $tasks->nextPageUrl() }}" class="page-link" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">&raquo;</span>
            </li>
        @endif
    </ul>
</div>

        </div>
    </div>
