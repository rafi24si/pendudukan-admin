@extends('layouts.admin.app')
@section('title', 'Data KK')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa-solid fa-users me-2"></i> Data KK</h5>
        <a href="{{ route('keluarga-kk.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Tambah KK
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTER + SEARCH --}}
    <form method="GET" class="mb-3">
        <div class="row">

            <div class="col-md-2">
                <select name="rt" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua RT</option>
                    @foreach(range(1,20) as $r)
                        <option value="{{ $r }}" {{ request('rt') == $r ? 'selected':'' }}>
                            {{ $r }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="rw" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua RW</option>
                    @foreach(range(1,20) as $r)
                        <option value="{{ $r }}" {{ request('rw') == $r ? 'selected':'' }}>
                            {{ $r }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SEARCH --}}
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Search">

                    <button type="submit" class="input-group-text">🔍</button>

                    @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search'=>null]) }}"
                           class="btn btn-outline-secondary ms-2">Clear</a>
                    @endif
                </div>
            </div>

        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Kepala Keluarga</th>
                        <th>Alamat</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kk as $item)
                        <tr>
                            <td>{{ ($kk->currentPage()-1) * $kk->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->kk_nomor }}</td>
                            <td>{{ optional($item->kepalaKeluarga)->nama ?? '-' }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->rt }}</td>
                            <td>{{ $item->rw }}</td>
                            <td>
                                <a href="{{ route('keluarga-kk.edit', $item->kk_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>

                                <form action="{{ route('keluarga-kk.destroy', $item->kk_id) }}"
                                      method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3 text-muted">Belum ada data KK.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $kk->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection
