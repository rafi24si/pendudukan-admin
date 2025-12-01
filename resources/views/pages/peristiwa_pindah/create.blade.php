@extends('layouts.admin.app')
@section('title', 'Catat Peristiwa Pindah')

@section('content')
    <div class="container-fluid px-4">

        <h5 class="mb-3">
            <i class="fa fa-truck-moving me-2"></i> Catat Peristiwa Pindah
        </h5>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('peristiwa_pindah.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">

                        {{-- WARGA --}}
                        <div class="col-md-6">
                            <label class="form-label">Warga yang Pindah</label>
                            <select name="warga_id" class="form-control" required>
                                <option value="">-- Pilih Warga --</option>
                                @foreach ($warga as $w)
                                    <option value="{{ $w->warga_id }}">
                                        {{ $w->nama }} ({{ $w->no_ktp }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TANGGAL --}}
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pindah</label>
                            <input type="date" name="tgl_pindah" class="form-control" required>
                        </div>

                        {{-- TUJUAN --}}
                        <div class="col-md-6">
                            <label class="form-label">Alamat Tujuan</label>
                            <input type="text" name="alamat_tujuan" class="form-control" required>
                        </div>

                        {{-- ALASAN --}}
                        <div class="col-md-6">
                            <label class="form-label">Alasan Pindah</label>
                            <input type="text" name="alasan" class="form-control" required>
                        </div>

                        {{-- NO SURAT --}}
                        <div class="col-md-6">
                            <label class="form-label">Nomor Surat Pindah</label>
                            <input type="text" name="no_surat" class="form-control">
                        </div>

                        {{-- FOTO UPLOAD --}}
                        <div class="col-md-6">
                            <label class="form-label">Upload Foto Bukti Pindah</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">JPEG/PNG Max 2MB</small>
                        </div>

                    </div>

                    <button class="btn btn-primary mt-3">Simpan</button>
                    <a href="{{ route('peristiwa_pindah.index') }}" class="btn btn-secondary mt-3">Kembali</a>

                </form>


            </div>
        </div>

    </div>
@endsection
