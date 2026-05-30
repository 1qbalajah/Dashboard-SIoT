@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <h1 class="auth-title">Register</h1>

    <form action="/register" method="POST" novalidate>
        @csrf

        <!-- Name -->
        <div class="form-group">
            <input
                type="text"
                name="name"
                placeholder="Name"
                required
                oninvalid="this.setCustomValidity('kolum ini wajib di isi')"
                oninput="this.setCustomValidity('')"
                class="form-input"
            >
            @error('name')
                <p class="error-message">
                    <span class="error-dot"></span>
                    {{ str_contains($message, 'required') ? 'kolum ini wajib di isi' : $message }}
                </p>
            @enderror
        </div>

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

        <button type="submit" class="btn-primary">Register</button>
    </form>

    <p class="auth-footer">
        Sudah punya akun?
        <a href="/" class="auth-link">Login</a>
    </p>
</div>
@endsection