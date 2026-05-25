@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Pelanggan')

@section('page_title')
    <div class="container">
        <h1 class="hero-title">👥 Manajemen Pelanggan</h1>
        <p class="hero-sub">Kelola data pelanggan dan pantau aktivitas akun mereka</p>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title"></h1>
    </div>

    <div class="admin-card">
        <div class="admin-card-body p-0">
            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-60">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th class="text-center col-100">Pesanan</th>
                            <th class="text-center col-100">Status</th>
                            <th class="text-center col-120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggan as $p)
                        @php
                            $pesananCount = $p->pesanan()->count() ?? 0;
                        @endphp
                        <tr>
                            <td class="font-700 text-primary">{{ $loop->iteration }}</td>
                            <td>
                                <div class="font-600 text-dark">{{ $p->name }}</div>
                                <small class="muted">ID: {{ $p->id }}</small>
                            </td>
                            <td>
                                <a href="mailto:{{ $p->email }}" class="text-primary" style="text-decoration: none;">{{ $p->email }}</a>
                            </td>
                            <td class="muted">{{ $p->phone ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $pesananCount }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">Aktif</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.pelanggan.show', $p->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty-cell">
                                <i class="fas fa-user-friends empty-icon"></i>
                                <p class="mb-0 mt-1 font-600">Tidak ada pelanggan ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($pelanggan->hasPages())
    <div style="display: flex; justify-content: flex-end; margin-top: 24px;">
        {{ $pelanggan->links() }}
    </div>
    @endif
</div>

@endsection
