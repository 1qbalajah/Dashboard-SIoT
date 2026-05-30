@extends('layouts.app')

@section('title', 'Tambah Device')

@section('content')
<!-- Page Header (pakai class yang sudah ada di layout) -->
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('device.index') }}" class="btn-ghost">
            ← Kembali
        </a>
        <h1 class="headline-md mb-0">Tambah Device</h1>
        <div></div>
    </div>
</div>

<!-- Form Card (pakai class .card yang sudah ada) -->
<article class="card" style="max-width: 520px;">
    <form action="{{ route('device.store') }}" method="POST" novalidate>
        @csrf

        <!-- Serial Number (pakai class form yang sudah ada) -->
        <div class="form-group mb-3">
            <label for="serial_number" class="form-label required">
                Serial Number
            </label>
            <input
                type="text"
                id="serial_number"
                name="serial_number"
                value="{{ old('serial_number') }}"
                class="form-input @error('serial_number') is-invalid @enderror"
                placeholder="Masukkan serial number"
                required
                oninvalid="this.setCustomValidity('kolum wajib diisi')"
                oninput="this.setCustomValidity('')"
            >
            @error('serial_number')
                <p class="form-error">{{ str_contains($message, 'required') ? 'kolum wajib diisi' : $message }}</p>
            @enderror
        </div>

        <!-- Topic (pakai class form yang sudah ada) -->
        <div class="form-group mb-4">
            <label for="topic" class="form-label required">
                Topic
            </label>
            <input
                type="text"
                id="topic"
                name="topic"
                value="{{ old('topic') }}"
                class="form-input @error('topic') is-invalid @enderror"
                placeholder="Masukkan topic MQTT"
                required
                oninvalid="this.setCustomValidity('kolum wajib diisi')"
                oninput="this.setCustomValidity('')"
            >
            @error('topic')
                <p class="form-error">{{ str_contains($message, 'required') ? 'kolum wajib diisi' : $message }}</p>
            @enderror
        </div>

        <!-- Tombol (pakai class button yang sudah ada) -->
        <div class="form-actions">
            <a href="{{ route('device.index') }}" class="btn-ghost">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Simpan
            </button>
        </div>
    </form>
</article>
@endsection