                @if($post->tags)
                    <p class="tags">
                        @foreach( $post->tags as $tag )
                            <a href="{{ url("tag", $tag->id) }}" class="btn btn-warning btn-xs">
                            {{ $tag->name }}
                        </a>
                        @endforeach
                    </p>
                @endif
