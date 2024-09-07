        @auth
        <nav class="navigation">
            <div class="btn-group btn-group-sm pull_left">
                <a class="btn btn-default" href="{{ url('/') }}">All Posts</a>
                <a class="btn btn-default" href="{{ url('user/' . Auth::id()) }}">My Posts</a>
                <a class="btn btn-default" href="{{ url('post/create') }}">Add Post</a>
            </div>
            <div class="btn-group btn-group-sm pull_right">
                <div class="btn-group btn-group-sm pull_right">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                <a href="{{ route("user.edit", Auth::id()) }}" class="btn btn-default">
                {{ Auth::user()->email }}
            </a>
            <a class="btn btn-default" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>
            </div>
        </nav>
        @endauth
