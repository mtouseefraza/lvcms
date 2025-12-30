@if (isset($isAjax) && $isAjax)
    script|g|
    <div class="table-responsive">
            <table class="table table-sm  table-striped table-bordered">
                <thead class="bg-secondary  text-white">
                    <tr>
                        <x-DispThSort page="{{ route('models.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('models.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('models.index') }}" name='section_name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Section Name" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('models.index') }}" name='url' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Url" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('models.index') }}" name='description' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Description" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort  displayName="Permission"/>
                        <x-DispThSort  displayName="Action" width="100" />
                    </tr>
                </thead>
                <thead class="bg-secondary  text-white" id="frm-filters">
                    <tr>
                        <x-DispThFilter type='number' page="{{ route('models.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter page="{{ route('models.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' btnClear='true' />
                        <x-DispThFilter page="{{ route('models.index') }}" name='section_name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Section Name" showId="tbl-result" filtersId='frm-filters' otherId='other' btnClear='true' />
                        <x-DispThFilter page="{{ route('models.index') }}" name='url' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Url" showId="tbl-result" filtersId='frm-filters' otherId='other' btnClear='true' />
                        <x-DispThFilter page="{{ route('models.index') }}" name='description' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Description" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($models as $model)
                        <tr>
                            <td>{{ $model->id }}</td>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->section_name }}</td>
                            @if(Route::has($model->url))
                                <td><a href="{{ route($model->url) }}" target="_blank"> {{ route($model->url) }}</a></td>
                            @else
                                <td class="text-danger">Invalid Routing</td>
                            @endif
                            <td>{{ $model->description }}</td>
                            <td>
                                {{ implode(' | ', $model->permission) }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('models.edit', $model) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> <!-- Edit Icon -->
                                </a>
                                <form action="{{ route('models.destroy', $model) }}" method="POST" style="display:inline;">
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
                            <td colspan="7" class="text-center">No data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-end mt-2">
        {{ $models->links('vendor.pagination.custom-pagination-ajax', ['sortOrder' => $sortOrder, 'sortBy' => $sortBy, 'showId' => 'tbl-result', 'filtersId' => 'frm-filters', 'otherId' => 'other']) }}
    </div>
    |g|bindAjax();
    @php exit(); @endphp
@endif

{{--Start Page Here--}}
@extends('layouts.app')
@section('title', 'Models')
@section('content')
    {{--Show Table Here--}}
    @if (!empty($action) && $action == 'show')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">@yield('title', 'Card Title')</h5>
                <div class="btn-group">
                    <!-- Add New Models Button with Icon -->
                    <a href="{{ route('models.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i>
                    </a>
                    <!-- Print Button with Icon -->
                    <button class="btn btn-primary btn-sm" onclick="printElementById('tbl-result');">
                        <i class="fas fa-print"></i>
                    </button>
                    <div class="btn-group">
                        <a href="{{ route('models.export') }}" class="btn btn-primary btn-sm">
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
                <form action="{{ route('models.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-12 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter models name" 
                                   autocomplete="off" required>
                            @error('name')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" name="url" 
                                   class="form-control @error('url') is-invalid @enderror" 
                                   value="{{ old('url') }}" 
                                   placeholder="Enter model url" 
                                   autocomplete="off" required>
                            @error('url')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="section_id" class="form-label">Section Name</label>
                            <select name="section_id" 
                                    class="form-control @error('section_id') is-invalid @enderror" 
                                    required>
                                <option value="" disabled selected>Pick a section name</option>
                                @foreach ($sections as $key => $value)
                                    <option value="{{ $value['id'] }}" {{ old('section_id') == $value['id'] ? 'selected' : '' }}>{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            @error('section_id')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="permission" class="form-label">Permission</label>
                            <select name="permission[]" 
                                    class="form-control select2 @error('permission') is-invalid @enderror" 
                                    multiple required>
                                @foreach (permission() as $key => $value)
                                    <option value="{{ $value }}" 
                                        {{ is_array(old('permission')) && in_array($value, old('permission')) ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permission')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--  -->
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
                        <a class="btn btn-info me-2 text-white" href="{{ route('models.index') }}">
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
                <form action="{{ route('models.update', $models) }}" method="POST" autocomplete="off">
                    @csrf
                     @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-12 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') ? old('name') : $models->name }}" 
                                   placeholder="Enter models name" 
                                   autocomplete="off" required>
                            @error('name')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" name="url" 
                                   class="form-control @error('url') is-invalid @enderror" 
                                   value="{{ old('url') ? old('url') : $models->url }}" 
                                   placeholder="Enter model url" 
                                   autocomplete="off" required >
                            @error('url')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="section_id" class="form-label">Section Name</label>
                            <select name="section_id" 
                                    class="form-control @error('section_id') is-invalid @enderror" 
                                    required>
                                <option value="" disabled selected>Pick a section name</option>
                                @foreach ($sections as $key => $value)
                                    <option value="{{ $value['id'] }}" {{ old('section_id',$models->section_id) == $value['id'] ? 'selected' : '' }}>{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            @error('section_id')
                                <div class="invalid-feedback fade-out">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="permission" class="form-label">Permission</label>
                            <select name="permission[]" 
                                    class="form-control select2 @error('permission') is-invalid @enderror" 
                                    multiple  required>
                                @foreach (permission() as $key => $value)
                                    <option value="{{ $value }}" 
                                        {{ (is_array(old('permission')) && in_array($value, old('permission')) || in_array($value, $models->permission))  ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permission')
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
                                  autocomplete="off" required>{{ old('description') ? old('description') : $models->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback fade-out">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Buttons aligned to the right -->
                    <div class="text-end">
                        <a class="btn btn-info me-2 text-white" href="{{ route('models.index') }}">
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
        searchdata("{{ route('models.index') }}",'','tbl-result','hajsdhashd','other');
    });    
</script>    
@endsection
