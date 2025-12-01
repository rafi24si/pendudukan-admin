@extends('layouts.admin.app')
@section('title', 'Edit Peristiwa Kelahiran')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3"><i class="fa fa-pen me-2"></i> Edit Peristiwa Kelahiran</h5>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('peristiwa_kelahiran.update', $kelahiran->kelahiran_id) }}"
                  method="POST">
                @csrf @method('PUT')

                <div class="row g-3">

                    {{-- BAYI --}}
                    <div class="col-md-4">
                        <label class="form-label">Bayi</label>
                        <select name="warga_id" class="form-control" required>
                            @foreach($warga as $w)
                                <option value="{{ $w->warga_id }}"
                                    {{ $kelahiran->warga_id == $w->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }} ({{ $w->no_ktp }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TGL LAHIR --}}
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control"
                               value="{{ $kelahiran->tgl_lahir }}" required>
                    </div>

                    {{-- TEMPAT LAHIR --}}
                    <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                               value="{{ $kelahiran->tempat_lahir }}" required>
                    </div>

                    {{-- AYAH --}}
                    <div class="col-md-6">
                        <label class="form-label">Ayah</label>
                        <select name="ayah_warga_id" class="form-control">
                            <option value="">-- Pilih Ayah --</option>
                            @foreach($warga as $w)
                                <option value="{{ $w->warga_id }}"
                                    {{ $kelahiran->ayah_warga_id == $w->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- IBU --}}
                    <div class="col-md-6">
                        <label class="form-label">Ibu</label>
                        <select name="ibu_warga_id" class="form-control">
                            <option value="">-- Pilih Ibu --</option>
                            @foreach($warga as $w)
                                <option value="{{ $w->warga_id }}"
                                    {{ $kelahiran->ibu_warga_id == $w->warga_id ? 'selected' : '' }}>
                                    {{ $w->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- AKTA --}}
                    <div class="col-md-6">
                        <label class="form-label">Nomor Akta</label>
                        <input type="text" name="no_akta" class="form-control"
                               value="{{ $kelahiran->no_akta }}">
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('peristiwa_kelahiran.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
