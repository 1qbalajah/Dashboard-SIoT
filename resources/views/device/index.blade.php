@extends('layouts.app')

@section('title', 'Data Device')

@section('content')
<!-- Page Header -->
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="headline-md">Data Device</h1>
            <p class="body-md">Kelola dan pantau seluruh perangkat IoT Anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="/" class="btn-ghost">Home</a>
            <a href="{{ route('device.create') }}" class="btn-primary">+ Tambah Device</a>
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

<!-- Device Table Card -->
<article class="card" style="padding: 0; overflow: hidden;">
    <div class="px-3 py-2" style="border-bottom: 1px solid var(--outline-variant);">
        <span class="label-md">Daftar Perangkat</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="table-header">Serial Number</th>
                    <th class="table-header">Topic</th>
                    <th class="table-header">Dibuat</th>
                    <th class="table-header">Diupdate</th>
                    <th class="table-header text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devices as $device)
                <tr>
                    <!-- Serial Number (Mono font untuk ID teknis) -->
                    <td class="table-cell">
                        <span class="label-md" style="font-family: var(--font-mono); color: var(--primary);">
                            {{ $device->serial_number }}
                        </span>
                    </td>
                    
                    <!-- Topic -->
                    <td class="table-cell">
                        <span class="body-md">{{ $device->topic }}</span>
                    </td>
                    
                    <!-- Created At -->
                    <td class="table-cell">
                        <span class="body-sm" style="font-family: var(--font-mono); color: var(--on-surface-variant);">
                            {{ $device->created_at ? $device->created_at->format('d M Y, H:i') : '-' }}
                        </span>
                    </td>
                    
                    <!-- Updated At -->
                    <td class="table-cell">
                        <span class="body-sm" style="font-family: var(--font-mono); color: var(--on-surface-variant);">
                            {{ $device->updated_at ? $device->updated_at->format('d M Y, H:i') : '-' }}
                        </span>
                    </td>
                    
                    <!-- Actions -->
                    <td class="table-cell text-right">
                        <div class="action-buttons">
                            <a href="{{ route('device.edit', $device->id) }}" class="btn-ghost btn-sm">Edit</a>
                            <form action="{{ route('device.destroy', $device->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus device ini?')">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                            <p class="body-md">Data device belum ada</p>
                            <a href="{{ route('device.create') }}" class="btn-primary btn-sm mt-2">+ Tambah Device Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</article>

<!-- Pagination -->
@if($devices instanceof \Illuminate\Pagination\LengthAwarePaginator && $devices->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <p class="body-sm">Menampilkan {{ $devices->firstItem() }}-{{ $devices->lastItem() }} dari {{ $devices->total() }} device</p>
        <div>{{ $devices->links() }}</div>
    </div>
@endif
@endsection
