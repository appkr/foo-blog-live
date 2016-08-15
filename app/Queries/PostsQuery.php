<?php

namespace App\Queries;

use App\Post;
use App\Tag;

class PostsQuery
{
    /**
     * @param $slug
     * @return mixed
     */
    public function fetch($slug)
    {
        $model = Tag::pluck('slug')->contains($slug)
            ? Tag::whereSlug($slug)->first()->posts()
            : new Post;

        return $model->with('user')->latest()->paginate(3);
    }
}