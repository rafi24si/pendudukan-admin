 @extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Data KK</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pages.admin.keluarga_kk.update', $kk->kk_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nomor KK</label>
            <input type="text" name="kk_nomor" class="form-control"
                value="{{ old('kk_nomor', $kk->kk_nomor) }}" required>
            @error('kk_nomor') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">ID Kepala Keluarga</label>
            <input type="number" name="kepala_keluarga_warga_id" class="form-control"
                value="{{ old('kepala_keluarga_warga_id', $kk->kepala_keluarga_warga_id) }}">
            @error('kepala_keluarga_warga_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat', $kk->alamat) }}</textarea>
            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">RT</label>
                <input type="text" name="rt" class="form-control"
                    value="{{ old('rt', $kk->rt) }}">
                @error('rt') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">RW</label>
                <input type="text" name="rw" class="form-control"
                    value="{{ old('rw', $kk->rw) }}">
                @error('rw') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pages.admin.keluarga_kk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
