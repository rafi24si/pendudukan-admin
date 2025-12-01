@extends('layouts.admin.app')
@section('title', 'Edit Kelahiran')

@section('content')
<div class="container py-3">

    <h4 class="mb-3">Edit Peristiwa Kelahiran</h4>

    <form action="{{ route('pages.admin.peristiwa_kelahiran.update', $kelahiran->kelahiran_id) }}"
          method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Bayi</label>
            <select name="warga_id" class="form-control">
                @foreach($warga as $w)
                <option value="{{ $w->warga_id }}" {{ $kelahiran->warga_id == $w->warga_id ? 'selected' : '' }}>
                    {{ $w->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" class="form-control" value="{{ $kelahiran->tgl_lahir }}">
        </div>

        <div class="mb-3">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" value="{{ $kelahiran->tempat_lahir }}">
        </div>

        <div class="mb-3">
            <label>Ayah</label>
            <select name="ayah_warga_id" class="form-control">
                @foreach($warga as $w)
                <option value="{{ $w->warga_id }}" {{ $kelahiran->ayah_warga_id == $w->warga_id ? 'selected' : '' }}>
                    {{ $w->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Ibu</label>
            <select name="ibu_warga_id" class="form-control">
                @foreach($warga as $w)
                <option value="{{ $w->warga_id }}" {{ $kelahiran->ibu_warga_id == $w->warga_id ? 'selected' : '' }}>
                    {{ $w->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>No Akta</label>
            <input type="text" name="no_akta" class="form-control" value="{{ $kelahiran->no_akta }}">
        </div>

        <div class="mb-3">
            <label>Bukti Kelahiran (Opsional)</label>
            <input type="file" name="bukti_kelahiran" class="form-control">

            @if($kelahiran->bukti_kelahiran)
            <small class="text-muted">File sekarang: {{ $kelahiran->bukti_kelahiran }}</small>
            @endif
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('pages.admin.peristiwa_kelahiran.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection
