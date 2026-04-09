{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color:#4f46e5;text-decoration:none">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="bi bi-people-fill me-2" style="color:#4f46e5"></i>Daftar Mahasiswa</div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/NIM/email..."
                class="form-control form-control-sm" style="width:250px;border-radius:8px">
            <button type="submit" class="btn btn-sm" style="background:#4f46e5;color:#fff;border-radius:8px;padding:5px 14px">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Total Diagnosis</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:34px;height:34px;background:linear-gradient(135deg,#4f46e5,#06b6d4);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.82rem;flex-shrink:0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:0.85rem">{{ $user->name }}</div>
                                    <div style="font-size:0.72rem;color:#94a3b8">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-family:monospace;font-size:0.82rem;color:#475569">{{ $user->nim ?? '-' }}</td>
                        <td style="font-size:0.82rem">{{ $user->jurusan ?? '-' }}</td>
                        <td style="font-size:0.82rem">{{ $user->angkatan ?? '-' }}</td>
                        <td>
                            <span style="background:#ede9fe;color:#4f46e5;padding:3px 10px;border-radius:10px;font-size:0.78rem;font-weight:700">
                                {{ $user->diagnosis_sessions_count }}x
                            </span>
                        </td>
                        <td style="font-size:0.78rem;color:#94a3b8">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" style="font-size:0.78rem;background:#e0f2fe;color:#0284c7;padding:4px 10px;border-radius:6px;text-decoration:none;font-weight:600">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="font-size:0.78rem;background:#fee2e2;color:#dc2626;padding:4px 10px;border-radius:6px;border:none;font-weight:600;cursor:pointer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4" style="color:#94a3b8">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer d-flex justify-content-center py-3">{{ $users->links() }}</div>
    @endif
</div>
@endsection
