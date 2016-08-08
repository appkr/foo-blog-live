@extends('layouts.app')

@section('content')
  <h1 class="page-header">
    {{ $post->title }}
  </h1>

  <ul>
    <li>{{ $post->created_at->diffForHumans() }}</li>
    <li>{{ $post->user->name }}</li>
  </ul>

  <article>
    {{ $post->content }}
  </article>

  <ul>
    @foreach ($post->tags as $tag)
      <li>
        <a href="{{ route('tags.posts.index', $tag->slug) }}">
          {{$tag->name}}
        </a>
      </li>
    @endforeach
  </ul>

  <h2>List of Comments</h2>
@endsection