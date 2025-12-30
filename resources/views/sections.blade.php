@if (isset($isAjax) && $isAjax)
    script|g|
    <div class="table-responsive">
            <table class="table table-sm  table-striped table-bordered">
                <thead class="bg-secondary  text-white">
                    <tr>
                        <x-DispThSort page="{{ route('sections.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('sections.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('sections.index') }}" name='icon' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Icon" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('sections.index') }}" name='type' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Type" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('sections.index') }}" name='description' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Description" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort  displayName="Action" width="100" />
                    </tr>
                </thead>
                <thead class="bg-secondary  text-white" id="frm-filters">
                    <tr>
                        <x-DispThFilter type='number' page="{{ route('sections.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter page="{{ route('sections.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' btnClear='true' />
                        <x-DispThFilter page="{{ route('sections.index') }}" name='icon' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Icon" showId="tbl-result" filtersId='frm-filters' otherId='other' class='iconpicker' readOnly='true' btnClear='true' />
                        <x-DispThFilter type="select" :items="$type" page="{{ route('sections.index') }}" name='type' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Type" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter page="{{ route('sections.index') }}" name='description' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Description" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->name }}</td>
                            <td><i class="{{ $section->icon }}"></i></td>
                             <td>{{ $section->type }}</td>
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
                            <td colspan="6" class="text-center">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-end mt-2">
        {{ $sections->links('vendor.pagination.custom-pagination-ajax', ['sortOrder' => $sortOrder, 'sortBy' => $sortBy, 'showId' => 'tbl-result', 'filtersId' => 'frm-filters', 'otherId' => 'other']) }}
    </div>
    |g|bindAjax();
    @php exit(); @endphp
@endif

{{--Start Page Here--}}
@extends('layouts.app')
@section('title', 'Section')
@section('content')
    {{--Show Table Here--}}
    @if (!empty($action) && $action == 'show')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">@yield('title', 'Card Title')</h5>
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
                        <a href="{{ route('sections.export') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-file-excel"></i>
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
    @endif
    @if (!empty($action) && $action == 'create')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">Add @yield('title', 'Card Title')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sections.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-12 col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter section name" 
                                   autocomplete="off" required>
                            @error('name')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="text" name="icon" 
                                   class="form-control iconpicker @error('icon') is-invalid @enderror" 
                                   value="{{ old('icon') }}" 
                                   placeholder="Pick an icon" 
                                   autocomplete="off" required readonly>
                            @error('icon')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" 
                                    class="form-control @error('type') is-invalid @enderror" 
                                    required>
                                <option value="" disabled selected>Pick a type</option>
                                @foreach ($type as $key => $value)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="5" 
                                  placeholder="Enter a brief description" 
                                  autocomplete="off" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback fade-out">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Buttons aligned to the right -->
                    <div class="text-end">
                        <a class="btn btn-info me-2 text-white" href="{{ route('sections.index') }}">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="reset" class="btn btn-secondary me-2">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if (!empty($action) && $action == 'edit')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">Edit @yield('title', 'Card Title')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sections.update', $section) }}" method="POST" autocomplete="off">
                    @csrf
                     @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-12 col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') ? old('name') : $section->name }}" 
                                   placeholder="Enter section name" 
                                   autocomplete="off" required>
                            @error('name')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="text" name="icon" 
                                   class="form-control iconpicker @error('icon') is-invalid @enderror" 
                                   value="{{ old('icon') ? old('icon') : $section->icon }}" 
                                   placeholder="Pick an icon" 
                                   autocomplete="off" required readonly>
                            @error('icon')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" 
                                    class="form-control @error('type') is-invalid @enderror" 
                                    required>
                                <option value="" disabled selected>Pick a type</option>
                                @foreach ($type as $key => $value)
                                    <option value="{{ $key }}" 
                                        {{ old('type', $section->type) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="5" 
                                  placeholder="Enter a brief description" 
                                  autocomplete="off" required>{{ old('description') ? old('description') : $section->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback fade-out">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Buttons aligned to the right -->
                    <div class="text-end">
                        <a class="btn btn-info me-2 text-white" href="{{ route('sections.index') }}">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="reset" class="btn btn-secondary me-2">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
<script type="text/javascript">
    $(function(){
        searchdata("{{ route('sections.index') }}",'','tbl-result','hajsdhashd','other');
    });    
</script>    
@endsection
