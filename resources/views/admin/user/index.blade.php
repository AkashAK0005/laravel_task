@extends('admin.layout')
@section('title', 'Users')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Users</h3>
        <div class="btn-group gap-2">
            <a href="{{ route('user.exportCSV') }}" class="btn btn-success">
                Export CSV
            </a>
            <a href="{{ route('user.exportPDF') }}" class="btn btn-danger" target="_blank">
                Export PDF
            </a>
            <a href="{{ route('user.create') }}" class="btn btn-primary">Create User</a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('user.index') }}" class="mb-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <input id="search" name="search" type="text" class="form-control" 
                           placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search
                    </button>
                </div>
                @if(request('search'))
                <div class="col-2">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary w-100">
                        Clear Search
                    </a>
                </div>
                @endif
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Created At</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                        <form action="{{ route('user.destroy',$user) }}" method="POST">
                            <a class="btn btn-info btn-sm" href="{{ route('user.show',$user) }}">Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('user.edit',$user) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection