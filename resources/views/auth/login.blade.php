@extends('layouts.auth')

@section('title', 'Login - Portal Berita')

@section('content')
<div class="auth-container">
    <h2>Login</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <div class="mt-3 text-center">
        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
    </div>
</div>
@endsection