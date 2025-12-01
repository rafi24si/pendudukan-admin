@extends('layouts.admin.app')
@section('title', 'Data Warga')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa fa-users me-2"></i> Data Warga</h5>
        <a href="{{ route('warga.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Warga Baru
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-3">
        <div class="row">

            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        value="{{ request('search') }}" placeholder="Search warga">

                    <button type="submit" class="input-group-text">🔍</button>

                    @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                           class="btn btn-outline-secondary ms-2">
                            Clear
                        </a>
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
                        <th style="width:60px">No</th>
                        <th>No KTP</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Pekerjaan</th>
                        <th style="width:170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataWarga as $w)
                        <tr>
                            <td>{{ ($dataWarga->currentPage() - 1) * $dataWarga->perPage() + $loop->iteration }}</td>
                            <td>{{ $w->no_ktp }}</td>
                            <td>{{ $w->nama }}</td>
                            <td>{{ $w->jenis_kelamin }}</td>
                            <td>{{ $w->agama }}</td>
                            <td>{{ $w->pekerjaan }}</td>
                            <td>
                                <a href="{{ route('warga.edit', $w->warga_id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('warga.destroy', $w->warga_id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus warga {{ $w->nama }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Tidak ada data warga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $dataWarga->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection
