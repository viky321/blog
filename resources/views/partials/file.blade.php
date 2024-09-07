@if($post->tags)
<p class="files">
    @foreach($post->files as $file)
        <a href="{{ route("files.download", $file->id ) }}" class="btn btn-success btn-xs">
            {{ $file->name }} ({{ $file->extension }})
        </a>
    @endforeach
</p>
@endif
