@extends('admin.layout')
@section('title', 'Edit User')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit User</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('user.update', $user) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" value="{{ $user->phone }}" class="form-control @error('phone') is-invalid @enderror" required>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <h3>Images</h3>
                            @php
                                $images = $user->documents->where('file_type', 'image');
                            @endphp
                            @forelse ($images as $document)
                                <div style="margin-bottom: 20px;">
                                    <img src="{{ asset('storage/' . $document->file_name) }}" 
                                        alt="{{ basename($document->file_name) }}" 
                                        style="max-width: 100%; height: auto; max-height: 200px; border: 1px solid #ddd; border-radius: 5px; padding: 5px;">
                                </div>
                            @empty
                                <p>No images found.</p>
                            @endforelse
                        </div>
                   </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
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
                            <div class="col-md-6">
                                <h3>Resumes</h3>
                                @php
                                    $resumes = $user->documents->where('file_type', 'resume');
                                @endphp
                                <ul style="list-style: none; padding-left: 0;">
                                    @forelse ($resumes as $document)
                                    <li style="margin-bottom: 10px;">
                                        <a href="{{ asset('storage/' . $document->file_name) }}" 
                                        download 
                                        class="btn btn-sm btn-primary">
                                            <i class="fa fa-download"></i> Download {{ basename($document->file_name) }}
                                        </a>
                                    </li>
                                    @empty
                                    <li><p>No resumes found.</p></li>
                                    @endforelse
                                </ul>
                            </div>
                        
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update User</button>
            <a href="{{ route('user.show', $user) }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
@endsection