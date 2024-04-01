<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .sidebar {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 75px;
            left: 20px;
        }

        .nav-link {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 10px 20px;
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .logout-container {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: calc(100% - 40px);
        }

        .status-text {
            width: 62px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .sign-style{
            padding-right: 10px; margin-right: 5px; display: flex;
    flex-direction: column;
    margin-top: 10px;
    justify-content: center;
    border-radius: 46%;
    color: white;
    align-content: center;
    align-items: center;
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

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"></a>
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
            <button type="submit" class="logout-btn">Logout</button>
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
