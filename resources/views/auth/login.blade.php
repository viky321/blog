@extends('welcome')
@section("title", "Login")

@section("content")
<section class="box auth-form">
    <h1 class="box-heading text-muted">Login</h1>
    <form method="POST" action="{{ url('/login') }}">
        @csrf

        @if (session('url.intended'))
            <input type="hidden" name="intended" value="{{ session('url.intended') }}">
        @endif

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" checked>
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <div class="mt-4 text-center">
            <a href="https://github.com/login" target="_blank">Login with GitHub</a> |
            <a href="https://www.facebook.com/login" target="_blank">Login with Facebook</a> or
        </p>
        <p>Don't have an account? <a href="{{ url('/register') }}">Create one</a></p>
    </div>
</section>
@endsection
