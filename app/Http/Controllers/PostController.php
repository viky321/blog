<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\File;
use App\Models\Post;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SavePostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\UploadService;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \DB::enableQueryLog();


        $posts = Post::latest("created_at")->get();

        echo "<pre>";
        print_r( \DB::getQueryLog());
        echo "</pre>";


        return view ("posts.index")
        ->with( "posts" , $posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("posts.create")
        ->with("title", "Add new post");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePostRequest $request)
    {
        $post = Auth::user()->posts()->create($request->all());

        if ($request->hasFile('items')) {
            foreach ($request->file('items') as $file) {
                if ($file->isValid()) {
                    $this->uploadService->saveFile($file, $post);
                }
            }
        }

        $post->tags()->sync($request->get("tags") ?: []);

        return redirect()->route("posts.show", $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        return view ("posts.show")
        ->with("post", $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            $this->authorize('edit-post', $post);
        }

        $title = "Edit Post";

        return view('posts.edit', compact('post', 'title'));
    }

    public function delete(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            $this->authorize('edit-post', $post);
        }

        $title = "Delete Post";

        return view('posts.delete', compact('post', 'title'));
    }

    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(SavePostRequest $request, string $slug)
    {

        $post = Post::findOrFail($slug);

        // Overenie, či aktuálny používateľ môže editovať tento príspevok
        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        $validatedData = $request->validated();
        $post->update($validatedData);

        // Spracovanie nahratých súborov
        if ($request->hasFile('items')) {
            foreach ($request->file('items') as $file) {
                if ($file->isValid()) {
                    $this->uploadService->saveFile($file, $post);
                }
            }
        }

        return redirect()->route('posts.show', $post->id);
    }


        public function userPosts()
    {
        $user = Auth::user();
        $posts = $user->posts()->orderBy('updated_at', 'desc')->get();

        return view('posts.user_posts', compact('posts'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            $this->authorize('delete-post', $post);
        }

        // Mazanie súborov cez UploadService
        $this->uploadService->deleteFiles($post);


        // Vymazanie záznamu o príspevku z databázy
        $post->delete();

        return redirect()->route('user.posts', Auth::id())->with('success', 'Post deleted successfully');
    }


}
