@extends('layouts.admin.app')
@section('title', 'Data Peristiwa Kelahiran')

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .lahir-card {
        transition: .25s ease;
        border-radius: 14px;
 overflow: hidden;
    }

    .lahir-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 22px rgba(0,0,0,0.15);
    }

    .baby-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #fff1e6;
        color: #ff8c42;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 12px;
    }

    .lahir-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #333;
    }

    .lahir-info {
        font-size: .9rem;
        color: #666;
        margin-bottom: 4px;
    }

    .fade-in {
        animation: fadeIn .5s ease;
    }
    @keyframes fadeIn {
        from { opacity:0; transform: translateY(5px); }
        to   { opacity:1; transform: translateY(0); }
    }
</style>
@endpush


@section('content')
<div class="container-fluid px-3 px-lg-4 fade-in">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa fa-baby me-2"></i> Data Kelahiran</h5>
        <a href="{{ route('peristiwa_kelahiran.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-1"></i> Tambah Kelahiran
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        value="{{ request('search') }}" placeholder="Cari tempat lahir / no akta">

                    <button type="submit" class="input-group-text">🔍</button>

                    @if(request('search'))
                        <a href="{{ url('peristiwa-kelahiran') }}"
                           class="btn btn-outline-secondary ms-2">Clear</a>
                    @endif
                </div>
            </div>
        </div>
    </form>


    {{-- CARD GRID --}}
    <div class="row g-3">

        @forelse ($dataKelahiran as $k)
        <div class="col-md-6 col-lg-4 col-xl-3 fade-in">
            <div class="card lahir-card shadow-sm h-100">

                {{-- FOTO BUKTI --}}
                @if($k->media && count($k->media) > 0)
                    <img src="{{ asset('storage/' . $k->media[0]->file_url) }}"
                         class="w-100"
                         style="height: 160px; object-fit: cover;">
                @else
                    <div style="height:160px; background:#f3f4f6;"
                         class="d-flex justify-content-center align-items-center text-muted">
                        <i class="fa fa-image me-2"></i> Tidak ada foto
                    </div>
                @endif

                <div class="card-body">

                    {{-- ICON --}}
                    <div class="baby-icon">
                        <i class="fa fa-baby"></i>
                    </div>

                    {{-- NAMA BAYI --}}
                    <div class="lahir-title">
                        {{ $k->bayi?->nama ?? 'Bayi Tanpa Nama' }}
                    </div>

                    {{-- TANGGAL LAHIR --}}
                    <div class="lahir-info">
                        <i class="fa fa-calendar me-1"></i>
                        Lahir: <strong>{{ $k->tgl_lahir }}</strong>
                    </div>

                    {{-- TEMPAT LAHIR --}}
                    <div class="lahir-info">
                        <i class="fa fa-location-dot me-1"></i>
                        Tempat: <strong>{{ $k->tempat_lahir }}</strong>
                    </div>

                    {{-- AKTA --}}
                    <div class="lahir-info">
                        <i class="fa fa-file-alt me-1"></i>
                        Akta: <strong>{{ $k->no_akta ?? '-' }}</strong>
                    </div>

                    {{-- ORANG TUA --}}
                    <div class="lahir-info mt-2">
                        <i class="fa fa-person me-1"></i>
                        Ayah: <strong>{{ $k->ayah?->nama ?? '-' }}</strong>
                    </div>

                    <div class="lahir-info">
                        <i class="fa fa-person-dress me-1"></i>
                        Ibu: <strong>{{ $k->ibu?->nama ?? '-' }}</strong>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer bg-white border-0 d-flex justify-content-between">

                    {{-- EDIT --}}
                    <a href="{{ route('peristiwa_kelahiran.edit', $k->kelahiran_id) }}"
                       class="btn btn-sm btn-warning">
                        <i class="fa fa-pen"></i>
                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('peristiwa_kelahiran.destroy', $k->kelahiran_id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus data kelahiran {{ $k->bayi?->nama }}?');">
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
                <div class="card-body py-4 text-center text-muted">
                    Tidak ada data kelahiran.
                </div>
            </div>
        </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $dataKelahiran->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
