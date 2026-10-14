@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('sidebar')
    <a href="{{ route('guru.dashboard') }}" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
    <h3>Dashboard Guru</h3>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
@endsection