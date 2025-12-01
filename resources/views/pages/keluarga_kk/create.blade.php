@extends('layouts.admin.app')
@section('title', 'Tambah Keluarga KK')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3"><i class="fa fa-plus me-2"></i> Tambah Keluarga KK</h5>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('keluarga_kk.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nomor KK</label>
                        <input type="text" name="kk_nomor" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kepala Keluarga</label>
                        <select name="kepala_keluarga_warga_id" class="form-control" required>
                            <option value="">-- Pilih Warga --</option>
                            @foreach($warga as $w)
                                <option value="{{ $w->warga_id }}">{{ $w->nama }} ({{ $w->no_ktp }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control">
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('keluarga_kk.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
