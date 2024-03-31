<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container centered-form">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h2 class="h4 mb-3">Add New User</h2>
                        <div class="form-group">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="name" required maxlength="255" placeholder="name">
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email" required maxlength="255" placeholder="email">

                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter user password">
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="Admin">Admin</option>
                                <option value="Employee">Employee</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Save User</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>



</body>



</html>
