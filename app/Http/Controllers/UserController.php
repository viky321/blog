<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts;

        return view('posts.index', compact('posts', 'user'))
        ->with("title", $user->email);
    }

    public function userPosts($id)
    {
        $user = Auth::user();

        if ($user->id != $id) {
            abort(403, 'Unauthorized action.');
        }

        $posts = Post::where('user_id', $id)->get();

        return view('user.posts', compact('posts'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

         // Overenie, či aktuálny používateľ môže editovať tento účet (voliteľné)
         if ($user->id != auth()->id()) {
            abort(403); // Zakázaný prístup
        }

        $title = "Edit User";


        return view('auth.edit', compact('user', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != auth()->id()) {
            abort(403);
        }

        $validator = $this->validator( $request->all() );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $request->get('name');

        if ( $request->get("password")) {
            $user->password = Hash::make($request->get("password"));
        }

        if ($request->hasFile('profile_image')) {
            // Odstráni predchádzajúci profilový obrázok
            if ($user->profile_image) {
                Storage::disk('public')->delete('users/' . $user->id . '/' . $user->profile_image);
            }

            $file = $request->file('profile_image');
            $uniqueName = $file->getClientOriginalName() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'users/' . $user->id;
            $file->storeAs($path, $uniqueName, 'public');

            $user->profile_image = $uniqueName;
        }

        $user->save();

        return redirect()->route('user.edit', $id)->with('success', 'User updated successfully');
    }

    private function validator(array $data)
    {
        return \Validator::make($data, [
            "name" => "required|max:255",
            "password" => 'nullable|confirmed|min:6',

        ]);
    }


    public function removeProfileImage($id)
    {
        $user = User::findOrFail($id);

        if ($user->id != auth()->id()) {
            abort(403);
        }

        if ($user->profile_image) {
            Storage::disk('public')->delete('users/' . $user->id . '/' . $user->profile_image);
            $user->profile_image = null;
            $user->save();
        }

        return redirect()->route('user.edit', $id)->with('success', 'Profile image removed successfully.');
    }




}
