@extends('auth.layouts.app')
@section('title', 'Login')
@section('content')
<div class="d-flex align-items-center justify-content-center pt-2">
    <div class="" style="min-width: 40% !important;">
        <div class="card shadow-lg p-4 mb-5 bg-body rounded">
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center justify-content-center text-success">
                         <h2>Login</h2>
                    </div>    
                    <div class="mb-3 mt-3">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-lg" placeholder="Enter email" autocomplete="current-username" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <input type="password" name="password" id="pws"  class="form-control form-control-lg"  placeholder="Enter password" autocomplete="current-password" required>
                    </div>
                    @if ($errors->any())
                        <div>
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-warning alert-dismissible fade show" data-timeout="5000"  role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong>Warning!</strong> {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                          <strong>Success!</strong> {{ session('success') }}
                        </div>
                    @endif
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>
                    </div>    
                </form>
            </div>
        </div>    
    </div>
</div>
@endsection


