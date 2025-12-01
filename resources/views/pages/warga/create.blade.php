@extends('layouts.admin.app')
@section('title', 'Tambah Warga')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3"><i class="fa fa-plus me-2"></i> Tambah Warga Baru</h5>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('warga.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">No KTP</label>
                        <input type="text" name="no_ktp" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">No Telp</label>
                        <input type="text" name="telp" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('warga.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
