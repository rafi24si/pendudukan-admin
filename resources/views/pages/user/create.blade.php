@extends('layouts.admin.app')
@section('title','Tambah User')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  /* Sesuaikan dengan ukuran sidebar & header template-mu */
  :root{
    --sidebar-w:0px;   /* lebar sidebar desktop */
    --header-h:70px;     /* tinggi topbar/header */
  }
  @media (min-width: 992px){
    .content-wrap{ margin-left: var(--sidebar-w); padding-left: 1rem; }
  }
  .content-wrap{ padding-top: calc(var(--header-h) + 12px); }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0"><i class="fa fa-user-plus me-2"></i> Tambah User</h5>
    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
      <i class="fa fa-arrow-left me-1"></i> Kembali
    </a>
  </div>

  @if (session('error'))
    <div class="alert alert-danger mb-3">{!! session('error') !!}</div>
  @endif

  <div class="card">
    <div class="card-body">
      <form action="{{ route('user.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="name"
                 class="form-control @error('name') is-invalid @enderror"
                 value="{{ old('name') }}" required minlength="3" autocomplete="name"
                 placeholder="Nama lengkap">
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email"
                 class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email') }}" required autocomplete="email"
                 placeholder="nama@email.com">
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 required minlength="6" autocomplete="new-password"
                 placeholder="Minimal 6 karakter">
          @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" name="password_confirmation"
                 class="form-control" required autocomplete="new-password"
                 placeholder="Ulangi password">
        </div>

        <button class="btn btn-primary" type="submit">
          <i class="fa fa-save me-1"></i> Simpan
        </button>
        <a href="{{ route('user.index') }}" class="btn btn-light">Batal</a>
      </form>
    </div>
  </div>

</div>
@endsection
