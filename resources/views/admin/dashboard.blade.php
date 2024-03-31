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

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 70px;
        }

        .sidebar a {
            padding: 10px 20px;
            display: block;
            color: #000;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
    <script>
        window.onload = function() {
            var alertBox = document.getElementById('alertBox');
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 5000);
        }



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

            document.getElementById(sectionId).style.display = 'block';

            document.querySelector('a[href="#tasks"][onclick="toggleSection(\'' + sectionId + '\')"]').classList.add('active');
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

    <div class="sidebar">
        <a href="#tasks" onclick="toggleSection('tasks')" class="nav-link active">Tasks</a>
        <a href="#users" onclick="toggleSection('users')" class="nav-link">Users</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
        </form>
    </div>

    <!-- Welcome message -->
    <div class="content" id="dashboardContent">
        <div id="tasks" style="display: block;">
            @include('admin.component.taskTable')
        </div>
        <div id="users" style="display: none;">
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

</body>

</html>
