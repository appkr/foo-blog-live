<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return $post->comments()->with('user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $this->validate($request, ['content' => 'required']);
        $request->merge(['post_id' => $post->id]);
        $comment = $request->user()->comments()->create($request->all());

        return response()->json($comment->load('user')->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Comment $comment)
    {
        $this->validate($request, ['content' => 'required']);
        $this->authorize('update', $comment);
        $comment->update($request->all());

        return response()->json($comment->load('user')->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Comment $comment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return response()->json([], 204);
    }
}
