@extends('admin.layout')
@section('title', 'Create User')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Create User</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="images">Images</label>
                        <input type="file" name="images[]" id="images" class="form-control @error('images') is-invalid @enderror" multiple accept="image/*">
                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('images.*')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">You can select multiple images</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="resumes">Resumes</label>
                        <input type="file" name="resumes[]" id="resumes" class="form-control @error('resumes') is-invalid @enderror" multiple accept=".pdf,.doc,.docx">
                        @error('resumes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('resumes.*')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">You can select multiple resumes (PDF, DOC, DOCX)</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Create User</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
@endsection