@extends('layouts.villa')

@section('title', 'Kelola Profil')

@section('content')

    {{-- KRUSIAL: LOGIKA PEMISAH TAMPILAN BERDASARKAN PERAN PENGGUNA --}}
    @if (Auth::user()->role === 'admin')

        {{-- TAMPILAN ADMIN (Memuat Wrapper Admin) --}}
        @include('profile.profile-admin')
        
    @else
        
        {{-- TAMPILAN TAMU/GUEST (Memuat Wrapper Tamu) --}}
        @include('profile.profile-guest')
        
    @endif

@endsection