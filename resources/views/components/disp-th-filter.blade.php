<th class="th_{{$class}} "  >
    @if($type =='select')
        <select class="form-select form-select-sm {{$class}}" id="{{$id}}" name="{{$name}}" autocomplete="off" onchange="searchdata('{{ $page }}','sortBy={{$name}}&sortOrder={{$sortBy == $name && $sortOrder == 'asc' ? 'desc' : 'asc'}}','{{$showId}}','{{$filtersId}}','{{$otherId}}');">
          <option value=''>SELECT</option>
          @foreach ($items as $k=>$v)
            <option value="{{$k}}" {{($k === request($name) || $k === $value) ? "selected" : "" }}>{{$v}}</option>
          @endforeach
        </select>
    @else
        <div class="input-group input-group-sm">
            <input type="{{$type}}" onblur="if(this.value!=this.defaultValue){searchdata('{{ $page }}','sortBy={{$name}}&sortOrder={{$sortBy == $name && $sortOrder == 'asc' ? 'desc' : 'asc'}}','{{$showId}}','{{$filtersId}}','{{$otherId}}');}" class="form-control form-control-sm {{$class}}" name="{{$name}}" placeholder="{{$placeholder}}" value="{{ request($name) ? request($name) : $value }}" id="{{$id}}" autocomplete="off" {{$readOnly ? 'readonly' : ''}}>
            @if($btnClear)
                <span class="input-group-text" onclick="$('.th_{{$class}} input').val('').trigger('onblur');"><i class="fa-solid fa-eraser"></i></span>
            @endif    
        </div>
    @endif
</th>