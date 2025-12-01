@extends('layouts.admin.app')
@section('title','Tambah Anggota')

@section('content')
<div class="container-fluid py-3">

    <h4>Tambah Anggota Keluarga</h4>

    <form method="POST" action="{{ route('pages.admin.anggota_keluarga.store') }}">
        @csrf

        <div class="mb-3">
            <label>No KK</label>
            <select name="kk_id" class="form-control">
                @foreach($kk as $k)
                <option value="{{ $k->kk_id }}">{{ $k->kk_nomor }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Warga</label>
            <select name="warga_id" class="form-control">
                @foreach($warga as $w)
                <option value="{{ $w->warga_id }}">{{ $w->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Hubungan</label>
            <input type="text" name="hubungan" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('pages.admin.anggota_keluarga.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection
