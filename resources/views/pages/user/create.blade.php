@extends('layouts.admin.app')
@section('title', 'Tambah User')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        transition: all 0.3s;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #212529;
        box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.1);
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-radius: 0 10px 10px 0 !important;
        cursor: pointer;
        border-left: none;
    }
    /* Password Strength UI */
    .strength-meter {
        height: 4px;
        background-color: #eee;
        margin-top: 8px;
        border-radius: 2px;
        overflow: hidden;
    }
    .strength-bar {
        height: 100%;
        width: 0;
        transition: all 0.3s;
    }
    .indicator-text {
        font-size: 0.75rem;
        margin-top: 4px;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Tambah User Baru</h4>
            <p class="text-muted small mb-0">Pastikan data yang dimasukkan sudah benar.</p>
        </div>
        <a href="{{ route('user.index') }}" class="btn btn-outline-dark px-3" style="border-radius: 10px;">
            <i class="fa fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <i class="fa fa-exclamation-circle me-2"></i> {!! session('error') !!}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('user.store') }}" method="POST" id="userForm">
                        @csrf

                        <div class="row">
                            {{-- NAMA IC --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Nama IC</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fa fa-id-badge text-muted"></i></span>
                                    <input type="text" name="nama_ic"
                                           class="form-control border-start-0 @error('nama_ic') is-invalid @enderror"
                                           value="{{ old('nama_ic') }}" required
                                           placeholder="Contoh: Morris Diax">
                                </div>
                                @error('nama_ic')
                                    <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PASSWORD --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required minlength="6" placeholder="Buat password">
                                    <button type="button" class="input-group-text" onclick="togglePassword('password', this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <div class="strength-meter">
                                    <div id="strength-bar" class="strength-bar"></div>
                                </div>
                                <span id="strength-text" class="indicator-text text-muted">Kekuatan: -</span>
                            </div>

                            {{-- KONFIRMASI --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" id="confirm_password" name="password_confirmation"
                                           class="form-control" required placeholder="Ulangi password">
                                    <button type="button" class="input-group-text" onclick="togglePassword('confirm_password', this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <span id="match-text" class="indicator-text"></span>
                            </div>

                            {{-- ROLE --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Role Akses</label>
                                <select name="role" class="form-select border-start-1">
                                    <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member (Akses Terbatas)</option>
                                    <option value="petinggi" {{ old('role') == 'petinggi' ? 'selected' : '' }}>Petinggi (Akses Penuh)</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('user.index') }}" class="btn btn-light px-4" style="border-radius: 10px;">Batal</a>
                            <button class="btn btn-dark px-5 shadow-sm" type="submit" id="btnSubmit" style="border-radius: 10px; background: #000;">
                                <i class="fa fa-save me-2"></i> Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// 1. Toggle Password Visibility
function togglePassword(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// 2. Password Strength & Match Logic
const password = document.getElementById('password');
const confirm_password = document.getElementById('confirm_password');
const strengthBar = document.getElementById('strength-bar');
const strengthText = document.getElementById('strength-text');
const matchText = document.getElementById('match-text');

password.addEventListener('input', function() {
    const val = password.value;
    let strength = 0;

    if (val.length >= 6) strength += 25;
    if (val.match(/[A-Z]/)) strength += 25;
    if (val.match(/[0-9]/)) strength += 25;
    if (val.match(/[^A-Za-z0-9]/)) strength += 25;

    strengthBar.style.width = strength + "%";

    if (strength <= 25) {
        strengthBar.className = "strength-bar bg-danger";
        strengthText.innerText = "Kekuatan: Lemah";
    } else if (strength <= 75) {
        strengthBar.className = "strength-bar bg-warning";
        strengthText.innerText = "Kekuatan: Sedang";
    } else {
        strengthBar.className = "strength-bar bg-success";
        strengthText.innerText = "Kekuatan: Sangat Kuat";
    }
    checkMatch();
});

function checkMatch() {
    if (confirm_password.value === "") {
        matchText.innerText = "";
    } else if (password.value === confirm_password.value) {
        matchText.innerText = "✓ Password cocok";
        matchText.className = "indicator-text text-success";
    } else {
        matchText.innerText = "× Password tidak cocok";
        matchText.className = "indicator-text text-danger";
    }
}

confirm_password.addEventListener('input', checkMatch);

// 3. Simple Loading Button on Submit
document.getElementById('userForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnSubmit');
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
    btn.disabled = true;
});
</script>
@endpush
@endsection
