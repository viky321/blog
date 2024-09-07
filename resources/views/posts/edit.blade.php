@extends("master")


@section('title', $title)


@section('content')
<section class="box">
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="post" id="edit-form">
        @csrf
        @method('PUT')

        @include('posts.form', ['post' => $post, 'title' => $title])

    </form>
</section>
@endsection
