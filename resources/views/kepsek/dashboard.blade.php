@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@section('sidebar')
    <a href="{{ route('kepsek.dashboard') }}" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
@endsection

@section('content')
    <h3>Dashboard Kepala Sekolah</h3>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
@endsection