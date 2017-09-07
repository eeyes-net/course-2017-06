@foreach($data as $datum)
    <div class="box">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <p>
                        <a href="{{ action('Web\TeacherController@show', ['id' => $datum['id']]) }}">
                            <strong>{{ $datum['title'] }}</strong>
                        </a>
                        <small>{{ $datum['visit_count'] }}次访问</small>
                        <br>
                        {{ $datum['excerpt'] }}
                    </p>
                </div>
            </div>
        </article>
    </div>
@endforeach
