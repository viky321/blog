@extends("master")

@section('title', $title)

@section('content')

<section class="box">
    <form action="{{ url('post') }}" method="POST" enctype="multipart/form-data" class="post" id="add-form">
        @csrf

        @include('posts.form')

    </form>
@endsection
