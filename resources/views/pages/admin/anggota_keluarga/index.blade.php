@extends('layouts.admin.app')
@section('title','Anggota Keluarga')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between mb-3">
        <h4>Data Anggota Keluarga</h4>
        <a href="{{ route('pages.admin.anggota_keluarga.create') }}" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ================= FILTER + SEARCH ================= --}}
    <form method="GET" class="mb-3">
        <div class="row">

            {{-- FILTER KK --}}
            <div class="col-md-2">
                <select name="kk_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua KK</option>
                    @foreach(\App\Models\KeluargaKK::all() as $kk)
                        <option value="{{ $kk->kk_id }}"
                            {{ request('kk_id') == $kk->kk_id ? 'selected' : '' }}>
                            {{ $kk->kk_nomor }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FILTER WARGA --}}
            <div class="col-md-2">
                <select name="warga_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Warga</option>
                    @foreach(\App\Models\Warga::all() as $w)
                        <option value="{{ $w->warga_id }}"
                            {{ request('warga_id') == $w->warga_id ? 'selected' : '' }}>
                            {{ $w->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SEARCH --}}
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Search">

                    <button type="submit" class="input-group-text">
                        🔍
                    </button>

                    @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search'=>null]) }}"
                           class="btn btn-outline-secondary ms-2">
                           Clear
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </form>

    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No KK</th>
                    <th>Nama Warga</th>
                    <th>Hubungan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $a)
                <tr>
                    <td>{{ ($anggota->currentPage() - 1) * $anggota->perPage() + $loop->iteration }}</td>
                    <td>{{ $a->kk->kk_nomor }}</td>
                    <td>{{ $a->warga->nama }}</td>
                    <td>{{ $a->hubungan }}</td>
                    <td>
                        <a href="{{ route('pages.admin.anggota_keluarga.edit', $a->anggota_id) }}"
                           class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('pages.admin.anggota_keluarga.destroy',$a->anggota_id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus data?')" class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $anggota->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
