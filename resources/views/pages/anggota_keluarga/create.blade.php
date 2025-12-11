@extends('layouts.admin.app')
@section('title', 'Tambah User')

@section('content')
<div class="container-fluid px-4">

    <h5 class="mb-3"><i class="fa fa-user-plus me-2"></i> Tambah User</h5>

    <div class="card">
        <div class="card-body">

            {{-- ERROR ALERT --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('user.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- NAMA --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ROLE --}}
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="Super Admin" {{ old('role') == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="User" {{ old('role') == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required minlength="6">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CONFIRM --}}
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" required minlength="6">
                    </div>

                </div>

                <button class="btn btn-primary mt-3">
                    <i class="fa fa-check me-2"></i> Simpan
                </button>

                <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">Kembali</a>

            </form>

        </div>
    </div>

</div>
@endsection
