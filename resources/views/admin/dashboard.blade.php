<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
    <script>
        window.onload = function() {
            var alertBox = document.getElementById('alertBox');
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 5000);
        }
    </script>
</head>

<body>
    <!-- Navbar
    -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <!-- <a class="nav-link" href="#">Hello, Admin! <span class="sr-only">(current)</span></a> -->
                </li>
            </ul>
        </div>
    </nav>



    <!-- Welcome message -->
    <div class="container mt-4">
        <h1>Welcome to the Dashboard</h1>

        <!-- Task management section -->
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
                        <th scope="col">Task</th>
                        <th scope="col">Description</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Sign</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->start_date }}</td>
                        <td>{{ $task->end_date }}</td>
                        <td>{{ $task->user->name }}</td>
                        <td class="d-flex justify-content-between">
                            <!-- Edit Button -->
                            <button class="btn btn-success w-50" data-target="#editTaskModal-{{ $task->id }}" data-toggle="modal">Edit</button>

                            <!-- Delete Button -->
                            <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class=" btn btn-danger ">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @include('admin.component.editTaskModal', ['task' => $task, 'users' => $users])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="alertBox" class="alert-container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
























































</html>