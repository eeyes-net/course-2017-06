<div class="container">
    <nav class="pagination is-centered">
        <a href="{{ $data->url($data->currentPage() - 1) }}" class="pagination-previous" @if ($data->currentPage() === 1) disabled @endif>上一页</a>
        <a href="{{ $data->url($data->currentPage() + 1) }}" class="pagination-next" @if ($data->currentPage() === $data->lastPage()) disabled @endif>下一页</a>
        <ul class="pagination-list">
            @foreach (pageList($data->lastPage(), $data->currentPage(), 3) as $page)
                @if ($page['paginationEllipsis'])
                    <li><span class="pagination-ellipsis">&hellip;</span></li>
                @else
                    <li><a href="{{ $data->url($page['page']) }}" class="pagination-link @if ($page['isCurrent']) is-current @endif">{{ $page['page'] }}</a></li>
                @endif
            @endforeach
        </ul>
    </nav>
</div>