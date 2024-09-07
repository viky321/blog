<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;


class TagController extends Controller
{
    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        $posts = $tag->posts;

        return view('posts.index', compact('posts'));
    }
}
