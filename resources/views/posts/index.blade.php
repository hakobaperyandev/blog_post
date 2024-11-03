@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Blog Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>
    
    <form method="GET" action="{{ route('posts.index') }}" class="mb-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="form-control" />
        <button type="submit" class="btn btn-secondary mt-2">Search</button>
    </form>

    <div class="list-group">
        @foreach ($posts as $post)
            <div class="list-group-item">
                <h5>{{ $post->title }}</h5>
                <p>{{ Str::limit($post->content, 100) }}</p>
                <p><small>By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</small></p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-link">View</a>
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
        {{ $posts->links() }}
    </div>
</div>
@endsection
