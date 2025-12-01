@extends('layouts.admin.app')
@section('title', 'Tambah Peristiwa Kelahiran')

@section('content')
    <div class="container-fluid px-4">

        <h5 class="mb-3"><i class="fa fa-baby me-2"></i> Tambah Peristiwa Kelahiran</h5>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('peristiwa_kelahiran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        {{-- BAYI --}}
                        <div class="col-md-4">
                            <label class="form-label">Bayi (Warga)</label>
                            <select name="warga_id" class="form-control" required>
                                <option value="">-- Pilih Bayi --</option>
                                @foreach ($warga as $w)
                                    <option value="{{ $w->warga_id }}">{{ $w->nama }} ({{ $w->no_ktp }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TGL LAHIR --}}
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" required>
                        </div>

                        {{-- TEMPAT LAHIR --}}
                        <div class="col-md-4">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" required>
                        </div>

                        {{-- AYAH --}}
                        <div class="col-md-6">
                            <label class="form-label">Ayah</label>
                            <select name="ayah_warga_id" class="form-control">
                                <option value="">-- Pilih Ayah --</option>
                                @foreach ($warga as $w)
                                    <option value="{{ $w->warga_id }}">{{ $w->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- IBU --}}
                        <div class="col-md-6">
                            <label class="form-label">Ibu</label>
                            <select name="ibu_warga_id" class="form-control">
                                <option value="">-- Pilih Ibu --</option>
                                @foreach ($warga as $w)
                                    <option value="{{ $w->warga_id }}">{{ $w->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NO AKTA --}}
                        <div class="col-md-6">
                            <label class="form-label">Nomor Akta</label>
                            <input type="text" name="no_akta" class="form-control">
                        </div>

                        {{-- UPLOAD FOTO --}}
                        <div class="col-md-6">
                            <label class="form-label">Upload Bukti Kelahiran (opsional)</label>
                            <input type="file" name="bukti" class="form-control" accept="image/*">
                        </div>

                    </div>

                    <button class="btn btn-primary mt-3">Simpan</button>
                    <a href="{{ route('peristiwa_kelahiran.index') }}" class="btn btn-secondary mt-3">Kembali</a>

                </form>


            </div>
        </div>

    </div>
@endsection
