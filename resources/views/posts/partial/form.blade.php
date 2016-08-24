<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
  <label for="title"">Title</label>
  <input id="title" type="title" class="form-control" name="title" value="{{ old('title', $post->title) }}">
  @if ($errors->has('title'))
    <span class="help-block">
      <strong>{{ $errors->first('title') }}</strong>
    </span>
  @endif
</div>

<div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
  <label for="tags">Tags</label>
  <select id="tags" class="form-control" name="tags[]" multiple="multiple">
    <option disabled>Select one</option>
    @foreach ($allTags as $tag)
      @if ($errors->count())
        <option value="{{ $tag->id }}" {{ collection_contains(collect(old('tags')), $tag->id) ? 'selected="selected"' : ''}}>
      @else
        <option value="{{ $tag->id }}" {{ collection_contains($post->tags, $tag->id) ? 'selected="selected"' : ''}}>
      @endif
        {{ $tag->name }}
      </option>
    @endforeach
  </select>
  @if ($errors->has('tags'))
    <span class="help-block">
      <strong>{{ $errors->first('tags') }}</strong>
    </span>
  @endif
</div>

<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
  <label for="content">Content</label>
  <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $post->content) }}</textarea>
  @if ($errors->has('content'))
    <span class="help-block">
      <strong>{{ $errors->first('content') }}</strong>
    </span>
  @endif
</div>