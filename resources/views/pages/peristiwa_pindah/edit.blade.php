@extends('layouts.admin.app')
@section('title', 'Edit Peristiwa Pindah')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3">
        <i class="fa fa-pen me-2"></i> Edit Peristiwa Pindah
    </h5>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('peristiwa_pindah.update', $pindah->pindah_id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row g-3">

                    {{-- WARGA --}}
                    <div class="col-md-6">
                        <label class="form-label">Warga</label>
                        <select name="warga_id" class="form-control" required>
                            @foreach($warga as $w)
                                <option value="{{ $w->warga_id }}"
                                    {{ $pindah->warga_id == $w->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }} ({{ $w->no_ktp }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TANGGAL PINDAH --}}
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pindah</label>
                        <input type="date" name="tgl_pindah" class="form-control"
                               value="{{ $pindah->tgl_pindah }}" required>
                    </div>

                    {{-- ALAMAT TUJUAN --}}
                    <div class="col-md-6">
                        <label class="form-label">Alamat Tujuan</label>
                        <input type="text" name="alamat_tujuan" class="form-control"
                               value="{{ $pindah->alamat_tujuan }}" required>
                    </div>

                    {{-- ALASAN --}}
                    <div class="col-md-6">
                        <label class="form-label">Alasan Pindah</label>
                        <input type="text" name="alasan" class="form-control"
                               value="{{ $pindah->alasan }}" required>
                    </div>

                    {{-- NO SURAT --}}
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" name="no_surat" class="form-control"
                               value="{{ $pindah->no_surat }}">
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('peristiwa_pindah.index') }}" class="btn btn-secondary mt-3">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
