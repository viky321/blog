<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {

        $request->validate([
            'text' => 'required',
        ]);


    

        $comment = new Comment();
        $comment->post_id = $postId;
        $comment->user_id = Auth::id();
        $comment->text = $request->input('text');
        $comment->save();

        if ($request->ajax()) {
            $html = view('partials.comment', compact('comment'))->render();
            return response()->json(['html' => $html]);
        }

        // Nastavte ID nového komentára do session
        return redirect()->route('posts.show', $postId)->with('new_comment_id', $comment->id);
    }


    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.show', compact('comment'));
    }

    public function destroy(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Overenie, či je používateľ autorom komentára alebo adminom
        if (Auth::id() === $comment->user_id || Auth::user()->isAdmin()) {
            $comment->delete();

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Komentár bol úspešne vymazaný.');
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }



}
