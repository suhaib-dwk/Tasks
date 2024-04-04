<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .tasks-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            color: #333;
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
        }

        .btn-success {
            background-color: green !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="tasks-section mt-5">
            <h1>Hello, {{ auth()->user()->name }}!</h1>
            <h2>Task Schedule:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
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
                        <td>
                        @foreach ($task->users as $user)
                        @php
                        $submitStatus = $task->users()->wherePivot('user_id', $user->id)->wherePivot('submit', 1)->exists();
                        @endphp
                                                @endforeach

                            <form id="submissionForm{{ $task->id }}" action="{{ route('submit.task') }}" method="POST">

                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                @if ($submitStatus)
                                    <button type="button" class="btn btn-success" disabled>Submitted</button>
                                @else
                                    <button type="submit" class="btn btn-danger">Submission</button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Loop through each form
            $('form').each(function() {
                var form = $(this);
                var taskId = form.find('input[name="task_id"]').val();

                // Check submission status
                $.ajax({
                    type: 'GET',
                    url: '/check-submission/' + taskId,
                    success: function(response) {
                        if (response.submitted) {
                            var submitBtn = form.find('button[type="submit"]');
                            submitBtn.removeClass('btn-danger').addClass('btn-success').text('Submitted').prop('disabled', true);
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Form submission
            $('form').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    beforeSend: function() {
                        var submitBtn = form.find('button[type="submit"]');
                        submitBtn.prop('disabled', true);
                    },
                    success: function(response) {
                        var submitBtn = form.find('button[type="submit"]');
                        submitBtn.removeClass('btn-danger').addClass('btn-success').text('Submitted').prop('disabled', true);
                        alert(response.message);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                        var submitBtn = form.find('button[type="submit"]');
                        submitBtn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>

</html>
