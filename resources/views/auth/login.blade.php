@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <h1 class="auth-title">Login</h1>

    <form action="/login" method="POST" novalidate>
        @csrf

        <!-- Email -->
        <div class="form-group">
            <input
                type="email"
                name="email"
                placeholder="Email"
                required
                oninvalid="this.setCustomValidity('kolum ini wajib di isi')"
                oninput="this.setCustomValidity('')"
                class="form-input"
            >
            @error('email')
                <p class="error-message">
                    <span class="error-dot"></span>
                    {{ str_contains($message, 'required') ? 'kolum ini wajib di isi' : $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <input
                type="password"
                name="password"
                placeholder="Password"
                required
                oninvalid="this.setCustomValidity('kolum ini wajib di isi')"
                oninput="this.setCustomValidity('')"
                class="form-input"
            >
            @error('password')
                <p class="error-message">
                    <span class="error-dot"></span>
                    {{ str_contains($message, 'required') ? 'kolum ini wajib di isi' : $message }}
                </p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">Login</button>
    </form>

    <p class="auth-footer">
        Belum punya akun?
        <a href="/register" class="auth-link">Register</a>
    </p>
</div>
@endsection