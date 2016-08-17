<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        $posts = (new \App\Queries\PostsQuery)->fetch($slug);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
            'post' => new Post
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PostsRequest
     * @return \Illuminate\Http\Response
     */
    public function store(PostsRequest $request)
    {
        $post = $request->user()->posts()->create($request->all());
        $post->tags()->sync($request->input('tags'));
        flash('Post saved!', 'success');

        return redirect(route('posts.show', $post->id));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Post $post)
    {
        $post->load('user', 'tags');

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PostsRequest $request
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostsRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($request->all());
        $post->tags()->sync($request->input('tags'));
        flash('Post updated!', 'success');

        return redirect(route('posts.show', $post->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json([], 204);
    }
}
