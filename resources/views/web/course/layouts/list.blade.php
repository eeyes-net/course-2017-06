@foreach($data as $datum)
    <div class="box">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <p>
                        <a href="{{ action('Web\CourseController@show', ['id' => $datum['id']]) }}">
                            <strong>{{ $datum['title'] }}</strong>
                        </a>
                        <small>{{ $datum['visit_count'] }}次访问</small>
                        <br>
                    {{ $datum['excerpt'] }}
                    @if (isset($datum['categories']))
                        <div class="tags">
                            @foreach($datum['categories'] as $category)
                                <a href="{{ action('Web\CategoryController@courses', ['name' => $category['name']]) }}"><span class="tag">{{ $category['name'] }}</span></a>
                            @endforeach
                        </div>
                        @endif
                        </p>
                </div>
            </div>
        </article>
    </div>
@endforeach
