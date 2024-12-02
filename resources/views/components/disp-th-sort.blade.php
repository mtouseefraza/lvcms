<th class="th_{{$class}}">
    <span onclick="searchdata('{{ $page }}','sortBy={{$name}}&sortOrder={{$sortBy == $name && $sortOrder == 'asc' ? 'desc' : 'asc'}}','{{$showId}}','{{$filtersId}}','{{$otherId}}');" class="{{$class}}">
        {{$displayName}}
        @if ($sortBy == $name)
            <i class="fas fa-sort-{{ $sortOrder == 'asc' ? 'up' : 'down' }}"></i>
        @else    
            <i class="fas fa-sort"></i>
        @endif
    </span>
</th>