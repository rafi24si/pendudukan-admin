@extends('layouts.admin.app')
@section('title', 'Users')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Custom UI Enhancements */
        .main-content-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            background-color: #ffffff;
        }
        .table thead th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #495057;
            border-top: none;
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            color: #343a40;
            vertical-align: middle;
        }
        .search-input {
            border-radius: 8px 0 0 8px !important;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
        }
        .search-button {
            border-radius: 0 8px 8px 0 !important;
            background-color: #212529;
            color: white;
            border: none;
            padding: 0 20px;
        }
        .search-button:hover {
            background-color: #000;
            color: white;
        }
        .btn-action {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .badge-role {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        /* Mengatur Pagination agar senada */
        .pagination .page-link {
            color: #212529;
            border: none;
            margin: 0 3px;
            border-radius: 6px;
        }
        .pagination .page-item.active .page-link {
            background-color: #212529;
            border-color: #212529;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- HEADER SECTION --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Data Pengguna</h4>
            <p class="text-muted small mb-0">Kelola informasi user dan hak akses sistem.</p>
        </div>
        <a href="{{ route('user.create') }}" class="btn btn-dark px-4 py-2 shadow-sm" style="border-radius: 10px;">
            <i class="fa fa-plus-circle me-2"></i>Tambah User
        </a>
    </div>

    {{-- SEARCH & FILTER --}}
    <div class="row mb-4">
        <div class="col-md-5">
            <form method="GET" class="d-flex">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control search-input"
                           value="{{ request('search') }}" placeholder="Cari nama atau IC...">
                    <button type="submit" class="btn search-button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('user.index') }}" class="btn btn-light ms-2 d-flex align-items-center border">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- DATA TABLE CARD --}}
    <div class="card main-content-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama IC</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataUser as $u)
                        <tr>
                            <td class="text-center text-muted fw-bold">
                                {{ ($dataUser->currentPage() - 1) * $dataUser->perPage() + $loop->iteration }}
                            </td>

                            <td>
                                <div class="fw-bold text-dark">{{ $u->nama_ic }}</div>
                            </td>

                            <td>
                                <code class="text-muted" style="letter-spacing: 2px;">••••••••</code>
                            </td>

                            <td>
                                @php
                                    $roleStyles = [
                                        'petinggi' => 'bg-dark text-white',
                                        'member'   => 'bg-light text-dark border',
                                    ][$u->role] ?? 'bg-light text-secondary';
                                @endphp
                                <span class="badge badge-role {{ $roleStyles }}">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>

                            <td class="small text-muted">
                                <i class="far fa-calendar-alt me-1"></i> {{ $u->created_at?->format('d M Y') }}<br>
                                <i class="far fa-clock me-1"></i> {{ $u->created_at?->format('H:i') }}
                            </td>

                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('user.edit', $u->id) }}"
                                       class="btn btn-outline-dark btn-action me-2"
                                       title="Edit User">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ route('user.destroy', $u->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus {{ $u->nama_ic }}?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-action" title="Hapus User">
                                            <i class="fa fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3" alt="Empty">
                                <p class="text-muted mb-0">Data user tidak ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Menampilkan {{ $dataUser->firstItem() ?? 0 }} sampai {{ $dataUser->lastItem() ?? 0 }} dari {{ $dataUser->total() }} data
                </div>
                <div>
                    {{ $dataUser->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
