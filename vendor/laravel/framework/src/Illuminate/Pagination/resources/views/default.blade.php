@if ($paginator->hasPages())
    <div class="btn-group btn-group-justified">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="disabled btn btn-default"><span class="fa fa-chevron-left"></span></a>
        @else
            <a  class="btn btn-default prev" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="btn btn-default disabled"><span>{{ $element }}</span></a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="btn btn-primary"><span>{{ $page }}</span></a>
                    @else
                        <a class="btn btn-default" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a  class="btn btn-default next" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-chevron-right"></i></a>
        @else
            <a class="btn btn-default disabled"><span  class="fa fa-chevron-right"></span></a>
        @endif
    </div>
@endif
