@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <p>Welcome, {{ Auth::user()->name }}!</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection