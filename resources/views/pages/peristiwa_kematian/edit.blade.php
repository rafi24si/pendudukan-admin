@extends('layouts.admin.app')
@section('title', 'Edit Peristiwa Kematian')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3"><i class="fa fa-pen me-2"></i> Edit Peristiwa Kematian</h5>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('peristiwa_kematian.update', $kematian->kematian_id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row g-3">

                    {{-- PILIH WARGA --}}
                    <div class="col-md-6">
                        <label class="form-label">Warga yang Meninggal</label>
                        <select name="warga_id" class="form-control" required>
                            @foreach($warga as $w)
                                <option value="{{ $w->warga_id }}"
                                    {{ $kematian->warga_id == $w->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }} ({{ $w->no_ktp }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TGL MENINGGAL --}}
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Meninggal</label>
                        <input type="date" name="tgl_meninggal" class="form-control"
                               value="{{ $kematian->tgl_meninggal }}" required>
                    </div>

                    {{-- SEBAB --}}
                    <div class="col-md-6">
                        <label class="form-label">Sebab</label>
                        <input type="text" name="sebab" class="form-control"
                               value="{{ $kematian->sebab }}" required>
                    </div>

                    {{-- LOKASI --}}
                    <div class="col-md-6">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control"
                               value="{{ $kematian->lokasi }}" required>
                    </div>

                    {{-- NOMOR SURAT --}}
                    <div class="col-md-6">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" name="no_surat" class="form-control"
                               value="{{ $kematian->no_surat }}">
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('peristiwa_kematian.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
