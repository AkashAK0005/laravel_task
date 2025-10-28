@extends('admin.layout')
@section('title', 'Show User')
@section('content')
<div class="card">
    <div class="card-header">
        <h3>Show User</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p>Name: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Phone: {{ $user->phone }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>Created At: {{ $user->created_at->format('d/m/Y') }}</p>
                <p>Updated At: {{ $user->updated_at->format('d/m/Y') }}</p>
            </div>
        </div>
        <div class="row">
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
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('user.edit', $user) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection