@if (isset($isAjax) && $isAjax)
    script|g|
    <div class="table-responsive">
            <table class="table table-sm  table-striped table-bordered">
                <thead class="bg-secondary  text-white">
                    <tr>
                        <x-DispThSort page="{{ route('user-permission.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('user-permission.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('user-permission.index') }}" name='Email' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="email" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort page="{{ route('user-permission.index') }}" name='description' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" displayName="Description" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThSort  displayName="Action" width="100" />
                    </tr>
                </thead>
                <thead class="bg-secondary  text-white" id="frm-filters">
                    <tr>
                        <x-DispThFilter type='number' page="{{ route('user-permission.index') }}" name='id' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="ID" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <x-DispThFilter page="{{ route('user-permission.index') }}" name='name' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Name" showId="tbl-result" filtersId='frm-filters' otherId='other' btnClear='true' />
                        <x-DispThFilter page="{{ route('user-permission.index') }}" name='email' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Email" showId="tbl-result" filtersId='frm-filters' otherId='other' class=''  btnClear='true' />
                        <x-DispThFilter page="{{ route('user-permission.index') }}" name='role' sortOrder="{{ $sortOrder }}" sortBy="{{ $sortBy }}" placeholder="Role" showId="tbl-result" filtersId='frm-filters' otherId='other' />
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($userpermission as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->role }}</td>
                            <td class="text-center">
                                <a href="{{ route('user-permission.edit', $row) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> <!-- Edit Icon -->
                                </a>
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
        {{ $userpermission->links('vendor.pagination.custom-pagination-ajax', ['sortOrder' => $sortOrder, 'sortBy' => $sortBy, 'showId' => 'tbl-result', 'filtersId' => 'frm-filters', 'otherId' => 'other']) }}
    </div>
    |g|bindAjax();
    @php exit(); @endphp
@endif

{{--Start Page Here--}}
@extends('layouts.app')
@section('title', 'User Permission')
@section('content')
    {{--Show Table Here--}}
    @if (!empty($action) && $action == 'show')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">@yield('title', 'Card Title')</h5>
                <div class="btn-group">
                    <!-- Print Button with Icon -->
                    <button class="btn btn-primary btn-sm" onclick="printElementById('tbl-result');">
                        <i class="fas fa-print"></i>
                    </button>
                    <div class="btn-group">
                        <a href="{{ route('user-permission.export') }}" class="btn btn-primary btn-sm">
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
    @if (!empty($action) && $action == 'edit')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                <h5 class="mb-0">Edit @yield('title', 'Card Title')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user-permission.update', $user_id) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="card mb-2">
                        @forelse ($allmodels as $section => $models)
                            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="section-checkbox-{{ $loop->index }}">
                                    <label class="form-check-label" for="section-checkbox-{{ $loop->index }}">
                                        <strong>{{ $section }}</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">    
                                @forelse ($models as $model)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="model-checkbox-{{ $loop->parent->index }}-{{ $loop->index }}" value="{{ $model['id'] }}">
                                        <label class="form-check-label text-muted" for="model-checkbox-{{ $loop->parent->index }}-{{ $loop->index }}">
                                            <b>{{ $model['name'] }}</b>
                                        </label>
                                    </div>
                                    <div class="row m-1">
                                        @forelse ($model['permission'] as $p)
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="permission-checkbox-{{ $loop->parent->parent->index }}-{{ $loop->parent->index }}-{{ $loop->index }}" 
                                                           name="permission[{{ $model['id'] }}][{{ $p }}]" 
                                                           {{ !empty($model['selectedPermission'][$p]) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission-checkbox-{{ $loop->parent->parent->index }}-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                        {{ $p }}
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col">
                                                <span>No permissions available.</span>
                                            </div>
                                        @endforelse
                                    </div>
                                    <hr />
                                @empty
                                    <div class="text-center">
                                        No models found in this section.
                                    </div>
                                @endforelse
                            </div>
                        @empty
                            <div class="text-center">
                                No sections available.
                            </div>
                        @endforelse

                    </div>   
                    <!-- Buttons aligned to the right -->
                    <div class="text-end">
                        <a class="btn btn-info me-2 text-white" href="{{ route('user-permission.index') }}">
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
        searchdata("{{ route('user-permission.index') }}",'','tbl-result','hajsdhashd','other');
    });    
</script>    
@endsection
