@extends("master")

@section('title', $title)

@section('content')
<section class="box">
    <form action="{{ route('posts.delete', $post->id) }}" method="POST" class="post" id="delete-form">
        @csrf
        @method('DELETE')

        <header class="post-header">
            <h1 class="box-heading">
                Are you sure you want to delete this post?
            </h1>

            <blockquote class="form-group">
                <h3>{{ $post->title }}</h3>
                <p class="teaser">{{ $post->teaser }}</p>
            </blockquote>

            <div class="form-group">
                <button type="submit" class="btn btn-danger">Delete</button>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </header>

    </form>
</section>
@endsection
