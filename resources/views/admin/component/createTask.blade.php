<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container centered-form">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h2 class="h4 mb-3">Add New Task</h2>
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required maxlength="255" placeholder="Enter task title">
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required rows="4" placeholder="Task description"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_id" class="form-label">Assignees</label>
                            <select class="form-control" id="user_id" name="user_id[]" multiple required>
                                <option value="">Select employee(s)</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit"  class="btn btn-primary">Save Task</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
        $('#user_id').select2();
    });
        document.addEventListener("DOMContentLoaded", function() {
            var startDateInput = document.getElementById('start_date');
            var endDateInput = document.getElementById('end_date');

            var today = new Date().toISOString().split('T')[0];
            startDateInput.setAttribute('min', today);
            endDateInput.setAttribute('min', today);

            startDateInput.addEventListener('change', function() {
                var selectedStartDate = startDateInput.value;
                endDateInput.setAttribute('min', selectedStartDate);
            });

            endDateInput.addEventListener('change', function() {
                var selectedEndDate = endDateInput.value;
                var selectedStartDate = startDateInput.value;
                if (selectedEndDate < selectedStartDate) {
                    endDateInput.value = selectedStartDate;
                }
            });
        });
    </script>
</body>



</html>
