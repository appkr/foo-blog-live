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

  <div class="text-center">
    <a href="{{ route('posts.index') }}" class="btn btn-default">List</a>
    @can('update', $post)
      <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
    @endcan
    @can('delete', $post)
      <button class="btn btn-danger" @click="deletePost">Delete</button>
    @endcan
  </div>

  <h2>List of Comments</h2>
@endsection

@push('script')
  <script>
    new Vue({
      el: 'body',

      methods: {
        deletePost: function(e) {
          if (confirm('Are you sure?')) {
            this.$http.delete('{{ route('posts.destroy', $post->id) }}')
              .then(function (response) {
                alert('Post deleted !');
                window.location.href = '{{ route('posts.index') }}';
              });
          }
        }
      }
    });
  </script>
@endpush