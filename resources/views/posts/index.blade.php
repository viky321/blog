@extends("master")

@section('title', $title ?? 'All the posts')

@section('content')

<section class="box post-list">
    <h1 class="box-heading text muted">
        @auth
        @if ($posts->isNotEmpty() && $posts->first()->user)
            <img src="{{ $posts->first()->user->profile_image_url }}" alt="Profile Image" class="profile-image-small">
        @endif
        @endauth
        @yield('title', 'this is blog.foot')
    </h1>

    @forelse ($posts ?? [] as $post)
        <article id="post-{{ $post->id }}" class="post">
            <header class="post-header">
                <h2>
                    <a href="{{ url("post", $post->id)}}">{{ $post->title }}</a>
                    <time datetime="{{ $post->datetime }}">
                        <small>/ {{ $post->created_at }}</small>
                    </time>
                </h2>
                @include("partials.tags")
            </header>
            <div class="post-content">
                <p>{{ $post->teaser }}</p>
            </div>
            <footer class="post-footer">
                <div class="author-info">
                    @auth
                    <img src="{{ $post->user->profile_image_url }}" alt="Profile Image" class="profile-image-small">
                    @endauth
                    <span>{{ $post->user->email }}</span>
                </div>
                <a href="{{ url("post", $post->id)}}" class="read-more">read more</a>
            </footer>
        </article>
    @empty
        <p>No posts available.</p>
    @endforelse
</section>

@endsection
