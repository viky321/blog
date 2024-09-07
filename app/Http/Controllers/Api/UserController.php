<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Vráti všetkých používateľov ako JSON
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts;

        // Vrátia sa informácie o používateľovi a jeho príspevky ako JSON
        return response()->json([
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function userPosts($id)
    {
        $user = Auth::user();

        if ($user->id != $id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $posts = Post::where('user_id', $id)->get();

        // Vrátia sa príspevky používateľa ako JSON
        return response()->json($posts);
    }
}
