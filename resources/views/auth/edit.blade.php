@extends("master")


@section('title', $title)


@section('content')

<section class="box">
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="post" id="edit-form">
        @csrf
        @method('PUT')

        <section class="box auth-form">
            <h1 class="box-heading text-muted">{{ $title }}</h1>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password (optional):</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>


                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    @if($user->profile_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/users/' . $user->id . '/' . $user->profile_image) }}" alt="Profile Image" style="max-width: 200px;">
                            <a href="{{ route('user.removeProfileImage', $user->id) }}" class="btn btn-danger btn-sm">Remove Image</a>
                        </div>
                    @endif
                    <input type="file" name="profile_image" id="profile_image" class="form-control">
                </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ $title }}</button>
            </div>



        <span class="or">
            or <a href="{{ url()->previous() }}">cancel</a>
        </span>
    </section>

    </form>
</section>
@endsection
