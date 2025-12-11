@extends('layouts.admin.app')
@section('title', 'Edit User')

@section('content')
<div class="container-fluid px-3 px-lg-4 content-section">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa-solid fa-user-pen me-2"></i> Edit User</h5>
        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger mb-3">{!! session('error') !!}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}"
                           required minlength="3">

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}"
                           required>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ROLE (NEW) --}}
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="Super Admin" {{ $user->role === 'Super Admin' ? 'selected' : '' }}>
                            Super Admin
                        </option>
                        <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>
                            User
                        </option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PASSWORD OPSIONAL --}}
                <div class="mb-3">
                    <label class="form-label">Password (opsional)</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           minlength="6"
                           placeholder="Kosongkan jika tidak diubah">

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi password (opsional)">
                </div>

                {{-- BUTTON --}}
                <button class="btn btn-primary" type="submit">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Update
                </button>

                <a href="{{ route('user.index') }}" class="btn btn-light">Batal</a>

            </form>
        </div>
    </div>

</div>
@endsection
