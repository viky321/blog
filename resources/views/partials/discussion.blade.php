<!-- Zoznam komentárov -->
<div id="discussion" class="comments" data-url="{{ route('comments.store', $post->id) }}">
    <h3>Komentáre</h3>
    @foreach($post->comments as $comment)
        @include('partials.comment', ['comment' => $comment])
    @endforeach
</div>


<div class="comment-form">
    <h3>Pridať komentár</h3>
    @auth
        <form id="add-comment-form" method="POST" action="{{ route('comments.store', $post->id) }}" >
            @csrf
            <div class="form-group">
                <textarea name="text" class="form-control" placeholder="Napíšte komentár..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Odoslať komentár</button>
        </form>
    @else
        <p>Musíte byť prihlásený, aby ste mohli pridať komentár. <a href="{{ route('login') }}">Prihlásiť sa</a></p>
    @endauth
</div>




