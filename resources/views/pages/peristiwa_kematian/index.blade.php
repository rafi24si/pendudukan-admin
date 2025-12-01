@extends('layouts.admin.app')
@section('title', 'Data Peristiwa Kematian')

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .kematian-card {
        transition: .25s ease;
        border-radius: 14px;
        overflow: hidden;
    }

    .kematian-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 22px rgba(0,0,0,0.18);
    }

    .death-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #ffe7e7;
        color: #d90429;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 12px;
    }

    .km-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .km-info {
        font-size: .9rem;
        color: #666;
        margin-bottom: 3px;
    }
</style>
@endpush


@section('content')
<div class="container-fluid px-3 px-lg-4 fade-in">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa fa-skull-crossbones me-2"></i> Data Kematian</h5>
        <a href="{{ route('peristiwa_kematian.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Catat Kematian
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Cari lokasi / sebab / nomor surat">

                    <button type="submit" class="input-group-text">🔍</button>

                    @if (request('search'))
                        <a href="{{ url('peristiwa-kematian') }}"
                           class="btn btn-outline-secondary ms-2">Clear</a>
                    @endif
                </div>
            </div>
        </div>
    </form>


    {{-- CARD GRID --}}
    <div class="row g-3">

        @forelse ($dataKematian as $k)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card kematian-card shadow-sm">

                {{-- FOTO --}}
                @if($k->media->first())
                    <img src="{{ asset('storage/'.$k->media->first()->file_url) }}"
                         class="w-100"
                         style="height:160px; object-fit:cover;"
                         alt="Foto Kematian">
                @else
                    <div class="w-100 d-flex justify-content-center align-items-center bg-light"
                         style="height:160px; border-radius:8px;">
                        <span class="text-muted">
                            <i class="fa fa-image me-1"></i> Tidak ada foto
                        </span>
                    </div>
                @endif

                {{-- CARD BODY --}}
                <div class="card-body">

                    {{-- ICON --}}
                    <div class="death-icon">
                        <i class="fa fa-skull-crossbones"></i>
                    </div>

                    {{-- NAMA --}}
                    <div class="km-title">
                        {{ $k->warga?->nama ?? 'Tidak diketahui' }}
                    </div>

                    {{-- TANGGAL --}}
                    <div class="km-info">
                        <i class="fa fa-calendar me-1"></i>
                        Meninggal: <strong>{{ $k->tgl_meninggal }}</strong>
                    </div>

                    {{-- SEBAB --}}
                    <div class="km-info">
                        <i class="fa fa-heart-crack me-1"></i>
                        Sebab: <strong>{{ $k->sebab }}</strong>
                    </div>

                    {{-- LOKASI --}}
                    <div class="km-info">
                        <i class="fa fa-map-location-dot me-1"></i>
                        Lokasi: <strong>{{ $k->lokasi }}</strong>
                    </div>

                    {{-- NO SURAT --}}
                    <div class="km-info">
                        <i class="fa fa-file-alt me-1"></i>
                        Surat: <strong>{{ $k->no_surat ?? '-' }}</strong>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer bg-white border-0 d-flex justify-content-between">

                    {{-- EDIT --}}
                    <a href="{{ route('peristiwa_kematian.edit', $k->kematian_id) }}"
                       class="btn btn-sm btn-warning">
                        <i class="fa fa-pen"></i>
                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('peristiwa_kematian.destroy', $k->kematian_id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus data kematian {{ $k->warga?->nama }}?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>

                </div>

            </div>
        </div>
        @empty

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-4 text-muted">
                    Tidak ada data kematian.
                </div>
            </div>
        </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $dataKematian->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
