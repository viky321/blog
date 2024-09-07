<div class="comment" id="comment-{{ $comment->id }}" >
    <p>
        <strong>{{ $comment->user->name }}</strong>
        <small>{{ $comment->created_at->format('d.m.Y H:i') }}</small>
        @auth
            @if(Auth::id() == $comment->user_id)
                <!-- Tlačidlo na mazanie -->
                <button class="btn btn-danger btn-sm delete-comment" data-id="{{ $comment->id }}">
                    Vymazať
                </button>
            @endif
        @endauth
    </p>
    <p>{{ $comment->text }}</p>

</div>
