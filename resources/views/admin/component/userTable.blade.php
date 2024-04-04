<div class="container mt-4 tasks-section">
    <div class="row">
        <div class="col-md-6">
            <h2>User Management</h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.component.createUser') }}"class="btn btn-primary mb-3 mr-2"><i class="fas fa-plus"></i></a>
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
                            <button type="button" onclick="confirmDelete('{{ $user->id }}')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4">
    <ul class="pagination">
        @if ($users->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $users->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a>
            </li>
        @endif

        @php
            // Calculate the starting page number
            $startPage = $users->currentPage() > 9 ? $users->currentPage() - 9 : 1;
        @endphp

        @for ($i = $startPage; $i <= $users->lastPage(); $i++)
            @if ($i == $users->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $i }}</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $users->url($i) }}" class="page-link">{{ $i }}</a>
                </li>
            @endif
        @endfor

        @if ($users->hasMorePages())
            <li class="page-item">
                <a href="{{ $users->nextPageUrl() }}" class="page-link" rel="next">&raquo;</a>
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


