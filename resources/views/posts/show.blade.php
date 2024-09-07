@extends("master")


@section('title', $post->title)


@section('content')

<section class="box">
    <article class="post full-post">


    <header class="post-header">
    <h1 class="box-heading">
        <a href="{{ URL::current()}}">{{ $post->title }}</a>


        @if (Auth::check() && Auth::user()->id === $post->user_id)
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-xs edit-form">Edit</a>
            <a href="{{ route('posts.delete.confirm', $post->id) }}" class="btn btn-xs delete-button">Delete</a>
        @endif

        <time datetime="{{ $post->datetime }}">
            <small>{{ $post->created_at }}</small>
        </time>
    </h1>
    </header>

        <div class="post-content">
                {!! $post->rich_text !!}

            <p class="written-by small">
                <small>- written by
                <a href="{{ url("user", $post->user->id) }}">
                    {{ $post->user->email }}
                </a>
                </small>
            </p>
        </div>

        <footer class="post-footer">
            @include("partials.tags")
            @include("partials.file")
            @include("partials.discussion")
        </footer>

    </section>
</article>

@endsection
