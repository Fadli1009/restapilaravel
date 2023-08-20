<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::all();
        // return response()->json(['data' => $post]);
        return PostResource::collection($post);
    }

    public function create()
    {
        //
    }

    function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required'
        ]);
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function show($id)
    {
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post);
    }
    public function show2($id)
    {
        $post = Post::findOrFail($id);
        return new PostDetailResource($post);
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }
}