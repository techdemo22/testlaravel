@if ($paginator->hasPages())
<nav>   
    <ul class="pagination text-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item previous disabled">
                <a class="page-link">
                   &lsaquo;
                    <?php /*?><img src="{{ FRONT_IMG.'/arrow-down-sign-to-navigate.svg' }}"><?php */?>
                </a>
            </li>
        @else
            <li class="page-item previous">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <?php /*?><img src="{{ FRONT_IMG.'/arrow-down-sign-to-navigate.svg' }}"><?php */?>
                    &lsaquo;
                </a>
            </li>
        @endif

		@if ($paginator->onFirstPage())
		<li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
			<span class="page-link" aria-hidden="true">First</span>
		</li>
		@else
		<li class="page-item">
			<a class="page-link" href="{{ \Request::url() }}" rel="prev" aria-label="@lang('pagination.first')">First</a>
		</li>
		@endif
       
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif


            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
	
        @if ($paginator->hasMorePages())
			<li class="page-item">
				<a class="page-link" href="{{ \Request::url().'?page='.$paginator->lastPage() }}" rel="last" aria-label="@lang('pagination.last')">Last</a>
			</li>
		@else
			<li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
				<span class="page-link" aria-hidden="true">Last</span>
			</li>
		@endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item next">
                <a class=" page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                   &rsaquo;
                    <?php /*?><img src="{{ FRONT_IMG.'/arrow-down-sign-to-navigate.svg' }}"><?php */?>
                </a>
            </li>
        @else
            <li class="page-item next disabled">
                <a class=" page-link">
                   &rsaquo;
                    <?php /*?><img src="{{ FRONT_IMG.'/arrow-down-sign-to-navigate.svg' }}"><?php */?>
                </a>
            </li>
        @endif
    </ul>
</nav>    
@endif