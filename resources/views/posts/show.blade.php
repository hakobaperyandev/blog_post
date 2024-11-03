{{-- resources/views/posts/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p><small>By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</small></p>
    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
</div>
@endsection
