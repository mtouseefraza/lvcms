@if (isset($isAjax) && $isAjax)
    script|g|
    <div class="table-responsive">
            <table class="table table-sm  table-striped table-bordered">
                <thead class="bg-secondary  text-white">
                    <tr>
                        <x-DispThSort page="{{ route('sections.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('sections.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('sections.index') }}" name='icon' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Icon" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('sections.index') }}" name='description' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Description" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <th>Action</th>
                    </tr>
                </thead>
                <thead class="bg-secondary  text-white" id="frm-filters">
                    <tr>
                        <x-DispThFilter type="select" :items="['apple', 'banana', 'cherry']" page="{{ route('sections.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter type='number' page="{{ route('sections.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter page="{{ route('sections.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter page="{{ route('sections.index') }}" name='icon' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Icon" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter page="{{ route('sections.index') }}" name='description' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Description" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->icon }}</td>
                            <td>{{ $section->description }}</td>
                            <td class="text-center">
                                <a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> <!-- Edit Icon -->
                                </a>
                                <form action="{{ route('sections.destroy', $section) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> <!-- Delete Icon -->
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-end mt-2">
        {{ $sections->links('vendor.pagination.custom-pagination-ajax', ['sortOrder' => $sortOrder, 'sortBy' => $sortBy, 'showId' => 'tbl-result', 'filtersId' => 'frm-filters', 'otherId' => 'other']) }}
    </div>
    |g|
    @php exit(); @endphp
@endif

{{--Start Page Here--}}
@extends('layouts.app')
@section('title', 'Section')
@section('content')
    {{--Show Table Here--}}
    @if (!empty($action) && $action == 'show')
        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">Sections</h5>
                <div class="btn-group">
                    <!-- Add New Section Button with Icon -->
                    <a href="{{ route('sections.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i>
                    </a>
                    <!-- Print Button with Icon -->
                    <button class="btn btn-primary btn-sm" onclick="printElementById('tbl-result');">
                        <i class="fas fa-print"></i>
                    </button>
                    <div class="btn-group">
                        <a href="{{ route('sections.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export
                        </a>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="tbl-result"></div>
                </div>
            </div>
        </div>            
        <form id="other">
            <input type="hidden" id="custId" name="custId" value="3487">
            <input type="hidden" id="sds" name="asd" value="asds">
        </form>
        
    @endif
    @if (!empty($action) && $action == 'create')
        <div class="container">
            <h2>Add Section</h2>
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    @endif
    @if (!empty($action) && $action == 'edit')
        <div class="container">
            <h2>Edit Section</h2>
            <form action="{{ route('sections.update', $section) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $section->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" name="icon" class="form-control" value="{{ $section->icon }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ $section->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    @endif
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let removeScriptTags = function(str) {
        return str.replace(/<\/?script\b[^>]*>/gi, '');
    } 

    let searchdata = function(page, str, recId, frm ,otherform="") {
        let dt = '';
        if (frm != '') {
            if ($('#' + frm).prop("tagName") == 'FORM') {
                dt += $('#' + frm).serialize();
            } else {
                dt += $('#' + frm).find('input').serialize();
                dt += '&' + $('#' + frm).find('select').serialize();
            }
        }
        if (str != '') {
            dt += (dt != '' ? '&' : '') + str;
        }
        if (otherform != '')
        {
            dt += (dt != '' ? '&' : '') + $('#' + otherform).serialize();
        }
        
        $.ajax({type: 'GET', url: page, data: dt, success: function(data) {
            ReceiveData(recId,data);
        }});
    }

    let ReceiveData = function(recId, data) {
        if (data != '') {
            if (recId != '' && $('#'+recId).length) {
                if (data.indexOf("|g|") > 0) {
                    let arr = data.split("|g|");
                    if (arr[0].trim() == 'script') {
                        $('#' + recId).html(arr[1]).fadeIn(1000);
                        setTimeout(removeScriptTags(arr[2]), 1);
                        
                    }
                } else {
                    $('#' + recId).html(data).fadeIn(1000);
                }
            }else{
                $('#' + recId).html('<p>Invalid Id!</p>').fadeIn(1000);
            }
        }
    }

    function printElementById(id) {
        var printContents = document.getElementById(id).innerHTML;
        var originalContents = document.body.innerHTML;

        // Replace the body content with the content of the element to be printed
        document.body.innerHTML = printContents;

        // Trigger print dialog
        window.print();

        // Restore the original page content after printing
        document.body.innerHTML = originalContents;
    }

    searchdata("{{ route('sections.index') }}",'AId=ss&Flag=sdsfs&tabId=t1','tbl-result','hajsdhashd','other');

    
</script>    
@endsection
