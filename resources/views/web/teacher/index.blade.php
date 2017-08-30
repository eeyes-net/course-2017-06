<link rel="stylesheet" href="/css/bulma.min.css">

<div class="container">
    @foreach($data as $datum)
        <div class="box">
            <article class="media">
                <div class="media-left">
                    <figure class="image is-64x64">
                        <img src="http://bulma.io/images/placeholders/128x128.png" alt="Image">
                    </figure>
                </div>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <a href="/post/{{ $datum['id'] }}">
                                <strong>{{ $datum['title'] }}</strong>
                            </a>
                            <small>{{ $datum['visit_count'] }}次访问</small>
                            <br>
                        {{ $datum['excerpt'] }}
                        @if (isset($datum['categories']))
                            <div class="tags">
                                @foreach($datum['categories'] as $category)
                                    <span class="tag">{{ $category }}</span>
                                @endforeach
                            </div>
                            @endif
                            </p>
                    </div>
                </div>
            </article>
        </div>
    @endforeach
    <nav class="pagination is-centered">
        <a href="/post?page={{ $data->currentPage() - 1 }}" class="pagination-previous" @if ($data->currentPage() === 1) disabled @endif>Previous</a>
        <a href="/post?page={{ $data->currentPage() + 1 }}" class="pagination-next" @if ($data->currentPage() === $data->lastPage()) disabled @endif>Next page</a>
        <ul class="pagination-list">
            @foreach (pageList($data->lastPage(), $data->currentPage()) as $page)
                @if ($page['paginationEllipsis'])
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                @else
                    <li><a href="/post?page={{ $page['page'] }}" class="pagination-link @if ($page['isCurrent']) is-current @endif">{{ $page['page'] }}</a></li>
                @endif
            @endforeach
        </ul>
    </nav>
</div>