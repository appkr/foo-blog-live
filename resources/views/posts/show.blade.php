@extends('layouts.app')

@section('content')
  <h1 class="page-header">
    {{ $post->title }}
  </h1>

  <ul class="meta_list">
    <li>by {{ $post->user->name }}</li>
    <li>{{ $post->created_at->diffForHumans() }}</li>
  </ul>

  <article>
    {!! markdown($post->content) !!}
  </article>

  <ul class="tags_list">
    @foreach ($post->tags as $tag)
      <li><a href="{{ route('tags.posts.index', $tag->slug) }}">{{$tag->name}}</a></li>
    @endforeach
  </ul>

  <div class="text-center">
    <a href="{{ route('posts.index') }}" class="btn btn-default">List</a>
    @can('update', $post)
      <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">
        Edit
      </a>
    @endcan
    @can('delete', $post)
      <button class="btn btn-danger" @click="deletePost">
        Delete
      </button>
    @endcan
  </div>

  <h2>List of Comments</h2>

  @if (auth()->check())
    <form id="comments_create" @submit.prevent="createComment">
      {{--유효성 검사 에러 피드백 추가--}}
      <div class="form-group @{{ commentError.content.length ? 'has-error' : '' }}">
        <textarea id="content" class="form-control" placeholder="Leave your comment." v-model="commentContent"></textarea>
        <span class="help-block" v-if="commentError.content.length">
        <strong>@{{ commentError.content[0] }}</strong>
      </span>
      </div>

      <div class="form-group text-right">
        <button type="submit" class="btn btn-primary btn-sm">
          Comment
        </button>
      </div>
    </form>
  @else
    <div class="panel panel-default">
      <div class="panel-body">
        <h4 class="text-danger text-center">
          <a href="{{  route('login') }}">
            Login to post a comment.
          </a>
        </h4>
      </div>
    </div>
  @endif

  <ul v-if="comments.length">
    <li v-for="comment in comments | orderBy 'id' -1">
      <comment :comment="comment" @deleted="deleteComment" @updated="updateComment" inline-template>
        @{{ comment.content }}
        <small>
          <ul class="meta_list">
            <li>by @{{ comment.user.name }}</li>
            <li>@{{ comment.created_at }}</li>
            <li v-if="authorized">
              <a href="#" @click.prevent="toggleUpdateForm">Edit</a>
            </li>
            <li v-if="authorized">
              <a href="#" @click.prevent="deleteComment">Delete</a>
            </li>
          </ul>
        </small>

        <form @submit.prevent="updateComment" v-show="authorized && visible">
          <div class="form-group">
            <textarea class="form-control" v-model="newContent">@{{ comment.content }}</textarea>
          </div>

          <div class="form-group">
            <div class="text-right">
              <button type="submit" class="btn btn-primary btn-sm">
                Update
              </button>
            </div>
          </div>
        </form>
      </comment>
    </li>
  </ul>

  <h4 class="text-danger text-center" v-else>
    Please be the first to comment.
  </h4>
@endsection

@push('script')
  <script>
    Vue.component('comment', {
      props: ['comment'],

      data: function () {
        return {
          visible: false,
          newContent: ''
        }
      },

      computed: {
        authorized: function () {
          var currentUserId = '{{ auth()->check() ? auth()->user()->id : -1 }}' * 1;
          return (currentUserId === 1) || (currentUserId === this.comment.user_id);
        }
      },

      methods: {
        deleteComment: function () {
          this.$http.delete('/comments/' + this.comment.id)
            .then(function (response) {
              this.$dispatch('deleted', this.comment);
            });
        },

        toggleUpdateForm: function () {
          this.visible = ! this.visible;
        },

        updateComment: function () {
          this.$http.put('/comments/' + this.comment.id, { content: this.newContent })
            .then(function (response) {
              this.$dispatch('updated', response.json());
              this.toggleUpdateForm();
            });
        }
      }
    });

    new Vue({
      el: 'body',

      data: {
        comments: [],
        commentContent: '',
        flashMessage: {
          visible: false,
          type: 'info',
          message: 'Hello flash message!'
        },
        commentError: {
          content: []
        }
      },

      ready: function () {
        this.fetchComments();
        hljs.initHighlightingOnLoad();
      },

      methods: {
        deletePost: function(e) {
          if (confirm('Are you sure?')) {
            this.$http.delete('{{ route('posts.destroy', $post->id) }}')
              .then(function (response) {
                this.flash('Post deleted!', 'success');
                window.location.href = '{{ route('posts.index') }}';
              });
          }
        },

        fetchComments: function () {
          this.$http.get('{{ route('posts.comments.index', $post->id) }}')
            .then(function (response) {
              this.comments = response.data;
            });
        },

        createComment: function () {
          this.$http.post(
            '{{ route('posts.comments.store', $post->id) }}',
            { content: this.commentContent }
          ).then(function (response) {
            this.comments.push(response.json());
            this.commentContent = '';
            this.flash('Comment created!', 'success');
          }, function (response) {
            {{--유효성 검사 에러 피드백 추가--}}
            if (response.status == 422) {
              this.commentError = response.json();
            }
          });
        },

        deleteComment: function (comment) {
          this.comments.$remove(comment);
          this.flash('Comment deleted!', 'success');
        },

        updateComment: function (newComment) {
          var oldComment = _.filter(this.comments, {id: newComment.id});
          this.comments.$set(oldComment, newComment);
          this.flash('Comment updated!', 'success');
        },

        flash: function (message, type) {
          this.flashMessage = {
            message: message,
            type: type,
            visible: true
          }

          window.setTimeout(function () {
            this.flashMessage.visible = false;
          }.bind(this), 3000);
        }
      }
    });
  </script>
@endpush