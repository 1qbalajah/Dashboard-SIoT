@extends('layouts.app')

@section('title', 'Data Sensor')

@section('content')
<!-- Page Header -->
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="headline-md">Data Sensor</h1>
            <p class="body-md">Kelola dan pantau seluruh sensor IoT Anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="/" class="btn-ghost">Home</a>
            <a href="{{ route('sensor.create') }}" class="btn-primary">+ Tambah Sensor</a>
        </div>
    </div>
</div>

<!-- Alert Success -->
@if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<!-- Sensor Table Card -->
<article class="card" style="padding: 0; overflow: hidden;">
    <div class="px-3 py-2" style="border-bottom: 1px solid var(--outline-variant);">
        <span class="label-md">Daftar Sensor</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="table-header">Nama Sensor</th>
                    <th class="table-header">Data</th>
                    <th class="table-header">Dibuat</th>
                    <th class="table-header">Diupdate</th>
                    <th class="table-header text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sensors as $sensor)
                <tr>
                    <!-- Nama Sensor -->
                    <td class="table-cell">
                        <span class="body-md" style="font-weight: 500; color: var(--on-surface);">
                            {{ $sensor->nama_sensor }}
                        </span>
                    </td>
                    
                    <!-- Data Sensor (Mono font untuk nilai numerik/teknis) -->
                    <td class="table-cell">
                        <span class="label-md" style="font-family: var(--font-mono); color: var(--primary);">
                            {{ $sensor->data }}
                        </span>
                    </td>
                    
                    <!-- Created At -->
                    <td class="table-cell">
                        <span class="body-sm" style="font-family: var(--font-mono); color: var(--on-surface-variant);">
                            {{ $sensor->created_at ? $sensor->created_at->format('d M Y, H:i') : '-' }}
                        </span>
                    </td>
                    
                    <!-- Updated At -->
                    <td class="table-cell">
                        <span class="body-sm" style="font-family: var(--font-mono); color: var(--on-surface-variant);">
                            {{ $sensor->updated_at ? $sensor->updated_at->format('d M Y, H:i') : '-' }}
                        </span>
                    </td>
                    
                    <!-- Actions -->
                    <td class="table-cell text-right">
                        <div class="action-buttons">
                            <a href="{{ route('sensor.edit', $sensor->id) }}" class="btn-ghost btn-sm">Edit</a>
                            <form action="{{ route('sensor.destroy', $sensor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus sensor ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="table-empty">
                        <div class="text-center px-3 py-2">
                            <svg width="48" height="48" fill="none" stroke="var(--outline)" viewBox="0 0 24 24" style="margin: 0 auto 12px; opacity: 0.5;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p class="body-md">Data sensor belum ada</p>
                            <a href="{{ route('sensor.create') }}" class="btn-primary btn-sm mt-2">+ Tambah Sensor Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</article>

<!-- Pagination -->
@if($sensors instanceof \Illuminate\Pagination\LengthAwarePaginator && $sensors->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <p class="body-sm">Menampilkan {{ $sensors->firstItem() }}-{{ $sensors->lastItem() }} dari {{ $sensors->total() }} sensor</p>
        <div>{{ $sensors->links() }}</div>
    </div>
@endif
@endsection
