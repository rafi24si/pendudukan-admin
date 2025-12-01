@extends('layouts.admin.app')
@section('title', 'Edit Anggota Keluarga')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3"><i class="fa fa-pen me-2"></i> Edit Anggota Keluarga</h5>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('anggota_keluarga.update', $anggota->anggota_id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row g-3">

                    {{-- PILIH KK --}}
                    <div class="col-md-6">
                        <label class="form-label">No KK</label>
                        <select name="kk_id" class="form-control" required>
                            @foreach($kkList as $kk)
                                <option value="{{ $kk->kk_id }}"
                                    {{ $kk->kk_id == $anggota->kk_id ? 'selected' : '' }}>
                                    {{ $kk->kk_nomor }} - {{ $kk->kepalaKeluarga?->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PILIH WARGA --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama Warga</label>
                        <select name="warga_id" class="form-control" required>
                            @foreach($wargaList as $w)
                                <option value="{{ $w->warga_id }}"
                                    {{ $w->warga_id == $anggota->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }} ({{ $w->no_ktp }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- HUBUNGAN --}}
                    <div class="col-md-6">
                        <label class="form-label">Hubungan</label>
                        <input type="text" name="hubungan" class="form-control"
                               value="{{ $anggota->hubungan }}" required>
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('anggota_keluarga.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
