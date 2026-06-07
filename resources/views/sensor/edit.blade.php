@extends('layouts.app')

@section('title', 'Edit Sensor')

@section('content')
<!-- Page Header (pakai class yang sudah ada di layout) -->
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('sensor.index') }}" class="btn-ghost">
            Kembali
        </a>
        <h1 class="headline-md mb-0">Edit Sensor</h1>
        <div></div>
    </div>
</div>

<!-- Form Card (pakai class .card yang sudah ada) -->
<article class="card" style="max-width: 520px;">
    <form action="{{ route('sensor.update', $sensor->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <!-- Nama Sensor (pakai class form yang sudah ada) -->
        <div class="form-group mb-3">
            <label for="nama_sensor" class="form-label required">
                Nama Sensor
            </label>
            <input
                type="text"
                id="nama_sensor"
                name="nama_sensor"
                value="{{ old('nama_sensor', $sensor->nama_sensor) }}"
                class="form-input @error('nama_sensor') is-invalid @enderror"
                placeholder="Masukkan nama sensor"
                required
                oninvalid="this.setCustomValidity('kolum wajib diisi')"
                oninput="this.setCustomValidity('')"
            >
            @error('nama_sensor')
                <p class="form-error">{{ str_contains($message, 'required') ? 'kolum wajib diisi' : $message }}</p>
            @enderror
        </div>

        <!-- Data (pakai class form yang sudah ada) -->
        <div class="form-group mb-4">
            <label for="data" class="form-label required">
                Data
            </label>
            <input
                type="number"
                id="data"
                name="data"
                value="{{ old('data', $sensor->data) }}"
                class="form-input @error('data') is-invalid @enderror"
                placeholder="Masukkan nilai data"
                step="any"
                required
                oninvalid="this.setCustomValidity('kolum wajib diisi')"
                oninput="this.setCustomValidity('')"
            >
            @error('data')
                <p class="form-error">{{ str_contains($message, 'required') ? 'kolum wajib diisi' : $message }}</p>
            @enderror
        </div>

        <!-- Tombol (pakai class button yang sudah ada) -->
        <div class="form-actions">
            <a href="{{ route('sensor.index') }}" class="btn-ghost">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Update
            </button>
        </div>
    </form>
</article>
@endsection
