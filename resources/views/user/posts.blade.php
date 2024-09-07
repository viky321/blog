@extends('master')

@section('title', 'My Posts')

@section('content')
<section class="box">
    <h1 class="box-heading">My Posts</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($posts->isEmpty())
        <p>You have no posts.</p>
    @else
        <ul>
            @foreach($posts as $post)
                <li>
                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</section>
@endsection
