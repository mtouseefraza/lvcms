@if ($paginator->hasPages())
    <nav class="custom-pagination d-flex justify-content-between align-items-center">
        <div class="pagination-info pagination-sm">
            {{-- Pagination Summary --}}
            Showing 
            {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} 
            of 
            {{ $paginator->total() }}
        </div>

        <ul class="pagination pagination-sm">
            {{-- First Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" onclick="searchdata('{{ $paginator->url(1) }}','sortOrder={{ isset($sortOrder) ? $sortOrder : '' }}&sortBy={{ isset($sortBy) ? $sortBy : '' }}','{{ isset($showId) ? $showId : '' }}','{{ isset($filtersId) ? $filtersId : '' }}','{{ isset($otherId) ? $otherId : '' }}');">
                        <i class="fas fa-angle-double-left"></i> <!-- First -->
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-angle-double-left"></i> <!-- First -->
                    </span>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-angle-left"></i> <!-- Previous -->
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" onclick="searchdata('{{ $paginator->previousPageUrl() }}','sortOrder={{ isset($sortOrder) ? $sortOrder : '' }}&sortBy={{ isset($sortBy) ? $sortBy : '' }}','{{ isset($showId) ? $showId : '' }}','{{ isset($filtersId) ? $filtersId : '' }}','{{ isset($otherId) ? $otherId : '' }}');" rel="prev">
                        <i class="fas fa-angle-left"></i> <!-- Previous -->
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" onclick="searchdata('{{ $url }}','sortOrder={{ isset($sortOrder) ? $sortOrder : '' }}&sortBy={{ isset($sortBy) ? $sortBy : '' }}','{{ isset($showId) ? $showId : '' }}','{{ isset($filtersId) ? $filtersId : '' }}','{{ isset($otherId) ? $otherId : '' }}');">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" onclick="searchdata('{{ $paginator->nextPageUrl() }}','sortOrder={{ isset($sortOrder) ? $sortOrder : '' }}&sortBy={{ isset($sortBy) ? $sortBy : '' }}','{{ isset($showId) ? $showId : '' }}','{{ isset($filtersId) ? $filtersId : '' }}','{{ isset($otherId) ? $otherId : '' }}');" rel="next">
                        <i class="fas fa-angle-right"></i> <!-- Next -->
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-angle-right"></i> <!-- Next -->
                    </span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" onclick="searchdata('{{ $paginator->url($paginator->lastPage()) }}','sortOrder={{ isset($sortOrder) ? $sortOrder : '' }}&sortBy={{ isset($sortBy) ? $sortBy : '' }}','{{ isset($showId) ? $showId : '' }}','{{ isset($filtersId) ? $filtersId : '' }}','{{ isset($otherId) ? $otherId : '' }}');">
                        <i class="fas fa-angle-double-right"></i> <!-- Last -->
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-angle-double-right"></i> <!-- Last -->
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
