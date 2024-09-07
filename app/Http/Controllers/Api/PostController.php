<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Získa všetky príspevky a vráti ich ako JSON
        return response()->json(Post::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vytvorí nový príspevok a vráti ho ako JSON
        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Získa konkrétny príspevok podľa ID a vráti ho ako JSON
        return response()->json(Post::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Aktualizuje existujúci príspevok a vráti ho ako JSON
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Zmaže príspevok a vráti úspešnú odpoveď
        Post::destroy($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
