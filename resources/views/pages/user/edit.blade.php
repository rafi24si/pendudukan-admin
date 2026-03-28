@extends('layouts.admin.app')
@section('title', 'Edit User')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .edit-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }
    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
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
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 50px;
        background: #e9ecef;
        color: #6c757d;
    }
    /* Animasi sederhana untuk input yang berubah */
    .is-changed {
        border-color: #0d6efd !important;
        background-color: #fff !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Edit Profil User</h4>
            <p class="text-muted small mb-0">ID User: <span class="badge bg-light text-dark border">#{{ $user->id }}</span></p>
        </div>
        <a href="{{ route('user.index') }}" class="btn btn-outline-dark px-3" style="border-radius: 10px;">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {!! session('error') !!}
                </div>
            @endif

            <div class="card edit-card">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('user.update', $user->id) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- NAMA IC --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label d-flex justify-content-between">
                                    Nama IC
                                    <span class="status-badge" id="name-status">Original</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-signature text-muted"></i></span>
                                    <input type="text" name="nama_ic" id="nama_ic"
                                           class="form-control @error('nama_ic') is-invalid @enderror"
                                           value="{{ old('nama_ic', $user->nama_ic) }}" required
                                           data-original="{{ $user->nama_ic }}">
                                </div>
                                @error('nama_ic')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ROLE --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Role Akses</label>
                                <select name="role" id="role" class="form-select" data-original="{{ $user->role }}">
                                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="petinggi" {{ $user->role === 'petinggi' ? 'selected' : '' }}>Petinggi</option>
                                </select>
                            </div>

                            <div class="col-12 mt-2 mb-3">
                                <div class="p-3 bg-light rounded-3 border-start border-dark border-4">
                                    <small class="text-muted d-block">
                                        <i class="fa-solid fa-info-circle me-1"></i>
                                        Kosongkan password jika tidak ingin mengganti password user.
                                    </small>
                                </div>
                            </div>

                            {{-- PASSWORD --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           minlength="6" placeholder="Masukkan password baru">
                                    <button type="button" class="input-group-text" onclick="togglePassword('password', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- KONFIRMASI --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" id="confirm_password" name="password_confirmation"
                                           class="form-control" placeholder="Ulangi password">
                                    <button type="button" class="input-group-text" onclick="togglePassword('confirm_password', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <div id="match-feedback" class="small mt-1"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('user.index') }}" class="btn btn-light px-4" style="border-radius: 10px;">Batal</a>
                            <button class="btn btn-dark px-5 shadow-sm" type="submit" id="btnUpdate" style="border-radius: 10px; opacity: 0.8;">
                                <i class="fa-solid fa-arrows-rotate me-2"></i> Update Data
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
// 1. Toggle Password Visibility (Same as before for consistency)
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

// 2. Logic Unik: Change Detection
const form = document.getElementById('editUserForm');
const btnUpdate = document.getElementById('btnUpdate');
const inputsToWatch = form.querySelectorAll('[data-original]');

inputsToWatch.forEach(input => {
    input.addEventListener('input', () => {
        const originalValue = input.getAttribute('data-original');
        const statusBadge = document.getElementById(input.id + '-status');

        if (input.value !== originalValue) {
            input.classList.add('is-changed');
            if(statusBadge) {
                statusBadge.innerText = "Berubah";
                statusBadge.classList.replace('bg-light', 'bg-primary');
                statusBadge.classList.replace('text-dark', 'text-white');
            }
        } else {
            input.classList.remove('is-changed');
            if(statusBadge) {
                statusBadge.innerText = "Original";
                statusBadge.className = "status-badge";
            }
        }
        checkChanges();
    });
});

// Password interaction logic
const passInput = document.getElementById('password');
const confirmInput = document.getElementById('confirm_password');
const matchFeedback = document.getElementById('match-feedback');

function checkChanges() {
    let hasChanges = false;

    // Check text/select inputs
    inputsToWatch.forEach(input => {
        if (input.value !== input.getAttribute('data-original')) hasChanges = true;
    });

    // Check password input
    if (passInput.value.length > 0) hasChanges = true;

    // Light up the button if there are changes
    if (hasChanges) {
        btnUpdate.style.opacity = "1";
        btnUpdate.classList.replace('btn-dark', 'btn-primary'); // Opsional: ganti warna agar kontras
    } else {
        btnUpdate.style.opacity = "0.8";
        btnUpdate.classList.replace('btn-primary', 'btn-dark');
    }
}

// Password Match Feedback
confirmInput.addEventListener('input', () => {
    if (confirmInput.value === "") {
        matchFeedback.innerText = "";
    } else if (confirmInput.value === passInput.value) {
        matchFeedback.innerHTML = '<span class="text-success"><i class="fa-solid fa-check-circle"></i> Password Cocok</span>';
    } else {
        matchFeedback.innerHTML = '<span class="text-danger"><i class="fa-solid fa-times-circle"></i> Password Tidak Sama</span>';
    }
    checkChanges();
});

passInput.addEventListener('input', checkChanges);

// 3. Submit Loading State
form.addEventListener('submit', function() {
    btnUpdate.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
    btnUpdate.disabled = true;
});
</script>
@endpush
@endsection
