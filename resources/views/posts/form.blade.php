@php
    $post = $post ?? new \App\Models\Post;
@endphp


<form method="POST" action="{{ route('posts.store') }}">
    @csrf


<header class="post-header">
    <h1 class="box-heading">{{ $title }}</h1>
</header>

<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="form-control" placeholder="title what you need" value="{{ old('title', $post->title ?? '') }}">
</div>

<div class="form-group">
    <label for="text">Text</label>
    <textarea name="text" id="text" class="form-control" placeholder="write what you want" rows="16">{{ old('text', $post->text ?? '') }}</textarea>
    @error('text')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>



    {{-- items field --}}
    <div class="form-group add-files">
        <label for="items">Choose File:</label>
        <input type="file" name="items[]" id="items" class="form-control" multiple>
        <a href="javascript:void(0);" class="btn btn-default btn-xs pull-right add-more-files">one more</a>
    </div>



    {{-- Existing files --}}
    @if($post->exists && $post->files->isNotEmpty())
        <div class="form-group">
            <label>Existing Files:</label>
            <ul class="list-unstyled">
                @foreach($post->files as $file)
                    <li>
                        <a href="{{ asset('storage/posts/' . $file->filename) }}" target="_blank">{{ $file->name }}
                         ({{ $file->extension }})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif




<div class="form-group">
    <label>Tags</label><br>
    <div class="tags-container">
        @foreach($tags as $tag)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="tags[]" id="tag{{ $tag->id }}" value="{{ $tag->id }}" class="form-check-input" {{ (is_array(old('tags', $post->tags->pluck('id')->toArray() ?? [])) && in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray() ?? []))) ? 'checked' : '' }}>
                <label for="tag{{ $tag->id }}" class="form-check-label">{{ $tag->name }}</label>
            </div>
        @endforeach
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $title }}</button>
</div>

<span class="or">
    or <a href="{{ url()->previous() }}">cancel</a>
</span>

