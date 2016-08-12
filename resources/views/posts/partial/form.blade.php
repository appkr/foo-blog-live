<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
  <label for="title"">Title</label>
  <input id="title" type="title" class="form-control" name="title" value="{{ $post->title or old('title') }}">
  @if ($errors->has('title'))
    <span class="help-block">
      <strong>{{ $errors->first('title') }}</strong>
    </span>
  @endif
</div>

<div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
  <label for="tags"">Tags</label>
  <select id="tags" class="form-control" name="tags[]" multiple="multiple">
    <option disabled>Select one</option>
    <!--collect(old('tags))->contains($tag->id)-->
    <!--Extract to helper function-->
    @foreach ($allTags as $tag)
      <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected="selected"' : ''}}>
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
  <textarea name="content" id="content" rows="10" class="form-control">{{ $post->content or old('content') }}</textarea>
  @if ($errors->has('content'))
    <span class="help-block">
      <strong>{{ $errors->first('content') }}</strong>
    </span>
  @endif
</div>