<aside class="left-sidebar">

    {{-- CEK LOGIN --}}
    @if (!session()->has('user_id'))
        <div class="d-flex flex-column justify-content-center align-items-center text-center p-4" style="height: 70vh;">

            <div class="mb-3">
                <i class="ti ti-lock fs-1 text-warning"></i>
            </div>

            <h5 class="fw-bold text-warning mb-2">Akses Ditolak</h5>

            <p class="text-muted mb-3">
                Anda harus login terlebih dahulu untuk melihat menu.
            </p>

            <a href="{{ route('login.index') }}" class="btn btn-primary px-4">
                <i class="ti ti-login"></i> Login
            </a>
        </div>
    @else
        @php
            $isPetinggi = session('user_role') === 'petinggi';
        @endphp

        <div>
            {{-- LOGO --}}
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                    <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="Logo" />
                </a>

                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>

            {{-- MENU --}}
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">

                    {{-- TITLE --}}
                    <li class="nav-small-cap">
                        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                        <span class="hide-menu">Menu</span>
                    </li>

                    {{-- DASHBOARD --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg" href="{{ route('dashboard') }}">
                            <iconify-icon icon="solar:atom-line-duotone"></iconify-icon>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    {{-- ABSENSI --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg" href="{{ route('absensi.index') }}">
                            <iconify-icon icon="solar:calendar-line-duotone"></iconify-icon>
                            <span class="hide-menu">Absensi</span>
                        </a>
                    </li>

                    {{-- 🔥 USER (HANYA PETINGGI) --}}
                    @if ($isPetinggi)
                        <li class="sidebar-item">
                            <a class="sidebar-link primary-hover-bg" href="{{ route('user.index') }}">
                                <iconify-icon icon="solar:user-id-line-duotone"></iconify-icon>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                    @endif

                    @if (session('user_role') === 'petinggi')
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('absensi.rekap') }}">
                                <iconify-icon icon="solar:chart-line-duotone"></iconify-icon>
                                <span class="hide-menu">Rekap Absensi</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>

    @endif

</aside>
