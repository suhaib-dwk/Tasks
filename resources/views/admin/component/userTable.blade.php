<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h2>User Management</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.component.createUser') }}"class="btn btn-primary mb-3 mr-2">Add User</a>
        </div>
    </div>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                <form id="deleteForm{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('{{ $user->id }}')" class="btn btn-danger">Delete</button>
                        </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


