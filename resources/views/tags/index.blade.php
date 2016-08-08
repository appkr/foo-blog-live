<ul>
  @foreach ($allTags as $tag)
    <li>
      <a href="{{ route('tags.posts.index', $tag->slug) }}">
        {{ $tag->name }}
      </a>
    </li>
  @endforeach
</ul>