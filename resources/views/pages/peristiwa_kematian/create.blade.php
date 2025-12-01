@extends('layouts.admin.app')
@section('title', 'Catat Peristiwa Kematian')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3"><i class="fa fa-skull-crossbones me-2"></i> Catat Peristiwa Kematian</h5>

    <div class="card">
        <div class="card-body">

            {{-- FORM WAJIB ADA enctype UNTUK UPLOAD --}}
            <form action="{{ route('peristiwa_kematian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    {{-- PILIH WARGA --}}
                    <div class="col-md-6">
                        <label class="form-label">Warga yang Meninggal</label>
                        <select name="warga_id" class="form-control" required>
                            <option value="">-- Pilih Warga --</option>
                            @foreach($warga as $w)
                                <option value="{{ $w->warga_id }}">
                                    {{ $w->nama }} ({{ $w->no_ktp }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TGL MENINGGAL --}}
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Meninggal</label>
                        <input type="date" name="tgl_meninggal" class="form-control" required>
                    </div>

                    {{-- SEBAB --}}
                    <div class="col-md-6">
                        <label class="form-label">Sebab</label>
                        <input type="text" name="sebab" class="form-control" placeholder="Sakit, Kecelakaan, dll" required>
                    </div>

                    {{-- LOKASI --}}
                    <div class="col-md-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Rumah Sakit, Rumah, dll" required>
                    </div>

                    {{-- NOMOR SURAT --}}
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat Kematian</label>
                        <input type="text" name="no_surat" class="form-control">
                    </div>

                    {{-- UPLOAD FOTO --}}
                    <div class="col-md-6">
                        <label class="form-label">Upload Foto Bukti</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Opsional. Format: JPG/PNG. Max 2MB.</small>
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('peristiwa_kematian.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
