<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .tasks-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            min-width: 1704px;
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
            cursor: pointer;
            position: relative;
        }

        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .table th .sort-arrow {
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 5px;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.5;
        }

        .table th.sorted-asc .sort-arrow {
            border-bottom: none;
            border-top: 5px solid;
        }

        .table th.sorted-desc .sort-arrow {
            border-bottom: 5px solid;
            border-top: none;
        }

        .table th:hover .sort-arrow {
            opacity: 1;
        }

        .sidebar {
            background-color: #343a40;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .navbar {
            margin-left: 14%;
            background-color: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 987;
            width: 84%;
            margin-top: 22px;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }

        .profile-logo {
            width: 50%;
    height: 6%;
    margin-bottom: 32px;

        }

        .profile-initial {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #007bff;
            /* Change the background color as needed */
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            text-transform: uppercase;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1002;
            display: none;
        }

        .profile-dropdown-menu.show {
            display: block;
        }

        .profile-dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
        }

        .profile-dropdown-menu a:hover {
            background-color: #f0f0f0;
        }


        .content {
            padding: 20px;
            position: absolute;
            left: 252px;
        }

        .sign-style {
            padding-right: 10px;
            margin-right: 5px;
            display: flex;
            flex-direction: column;
            margin-top: 10px;
            justify-content: center;
            border-radius: 46%;
            color: white;
            align-content: center;
            align-items: center;
        }

        .status-text {
            width: 62px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;

        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <form class="form-inline">
            <div class="input-group">
                <input class="form-control mr-sm-2" type="search" placeholder="Search tasks" aria-label="Search" id="taskSearchInput">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" onclick="searchTasks()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>



        <div class="ml-auto profile-dropdown">
            <a class="nav-link" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="profile-initial">{{ substr(auth()->user()->name, 0, 1) }}</div>
            </a>
            <div class="profile-dropdown-menu" aria-labelledby="navbarDropdown">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a href="#" class="dropdown-item" onclick="document.getElementById('logout-form').submit()">Logout</a>
                </form>
            </div>
        </div>
    </nav>

    <div class="sidebar">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="profile-logo">

        <a href="#tasks" onclick="toggleSection('tasks')" class="active">Tasks</a>
        <a href="#users" onclick="toggleSection('users')">Users</a>
    </div>

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

    <!-- Welcome message -->
    <div class="content" id="dashboardContent">
        <div id="tasks" style="display: inline-block;">
            @include('admin.component.taskTable')
        </div>
        <div id="users" style="display: none;     padding-left: 17px;">
            @include('admin.component.userTable')
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.filter-column').click(function() {
                var column = $(this).data('column');
                var table = $('#tasks-table');
                var rows = table.find('tbody > tr').toArray().sort(comparer($(this).index()));
                this.asc = !this.asc;
                if (!this.asc) {
                    rows = rows.reverse();
                }
                for (var i = 0; i < rows.length; i++) {
                    table.append(rows[i]);
                }

                $('.filter-column').removeClass('sorted-asc sorted-desc');
                $(this).toggleClass('sorted-asc', this.asc);
                $(this).toggleClass('sorted-desc', !this.asc);
            });

            function comparer(index) {
                return function(a, b) {
                    var valA = getCellValue(a, index),
                        valB = getCellValue(b, index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
                }
            }

            function getCellValue(row, index) {
                return $(row).children('td').eq(index).text();
            }
        });

        window.onload = function() {
            var alertBox = document.getElementById('alertBox');
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 5000);
        };



        function confirmDelete(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                document.getElementById('deleteForm' + taskId).submit();
            }
        }

        function toggleSection(sectionId) {
            document.querySelectorAll('.content > div').forEach(function(section) {
                section.style.display = 'none';
            });

            document.querySelectorAll('.nav-link').forEach(function(link) {
                link.classList.remove('active');
            });

            document.getElementById(sectionId).style.display = 'inline-block';

            document.querySelector('a[href="#tasks"][onclick="toggleSection(\'' + sectionId + '\')"]').classList.add('active');
        };

        $('.profile-dropdown').on('click', function(e) {
            $('.profile-dropdown-menu').toggleClass('show');
            e.stopPropagation();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.profile-dropdown').length) {
                $('.profile-dropdown-menu').removeClass('show');
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function searchTasks() {
            var searchInput = document.getElementById('taskSearchInput').value;
            $.ajax({
                url: '/search/tasks',
                method: 'GET',
                data: {
                    query: searchInput
                },
                success: function(response) {
                    $('#taskModalBody').html(response);
                    $('#searchTask').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
</body>

</html>
