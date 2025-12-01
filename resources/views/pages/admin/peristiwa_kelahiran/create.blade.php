@extends('layouts.admin.app')
@section('title', 'Tambah Kelahiran')

@section('content')
<div class="container py-3">

    <h4 class="mb-3">Tambah Peristiwa Kelahiran</h4>

    <form action="{{ route('pages.admin.peristiwa_kelahiran.store') }}"
          method="POST" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Bayi</label>
            <select name="warga_id" class="form-control">
                <option value="">-- PILIH --</option>
                @foreach($warga as $w)
                <option value="{{ $w->warga_id }}">{{ $w->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control">
        </div>

        <div class="mb-3">
            <label>Ayah</label>
            <select name="ayah_warga_id" class="form-control">
                @foreach($warga as $w)
                <option value="{{ $w->warga_id }}">{{ $w->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Ibu</label>
            <select name="ibu_warga_id" class="form-control">
                @foreach($warga as $w)
                <option value="{{ $w->warga_id }}">{{ $w->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>No Akta</label>
            <input type="text" name="no_akta" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bukti Kelahiran</label>
            <input type="file" name="bukti_kelahiran" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('pages.admin.peristiwa_kelahiran.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection
