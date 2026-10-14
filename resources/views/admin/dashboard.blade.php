@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
    <h3>Dashboard Admin</h3>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
@endsection