<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        $model = \App\Tag::pluck('slug')->contains($slug)
            ? \App\Tag::whereSlug($slug)->first()->posts()
            : new Post;
        $posts = $model->with('user')->latest()->paginate(3);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', ['post' => new Post]);
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

        return redirect(route('posts.show', $post->id));
    }

    /**
     * Display the specified resource.
     *
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
        // 모델을 삭제한다.
        $post->delete();
        // 204 JSON 응답을 반환한다.
        return response()->json([], 204);
    }
}