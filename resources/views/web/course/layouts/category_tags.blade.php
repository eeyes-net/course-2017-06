<div class="tags">
    @foreach($tags as $tag)
        <a class="tag is-primary" href="{{ action('Web\CategoryController@courses', ['name' => $tag['name']]) }}">{{ $tag['name'] }}</a>
    @endforeach
</div>
