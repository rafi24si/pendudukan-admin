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
        {{-- ======================== --}}
        {{-- SIDEBAR ASLI (HANYA LOGIN) --}}
        {{-- ======================== --}}

        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                    <img src="../assets/images/logos/logo.svg" alt="Logo" />
                </a>

                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>

            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">

                    {{-- TITLE --}}
                    <li class="nav-small-cap">
                        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                        <span class="hide-menu">Menu</span>
                    </li>

                    {{-- DASHBOARD --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg" href="{{ route('dashboard') }}" aria-expanded="false">
                            <iconify-icon icon="solar:atom-line-duotone"></iconify-icon>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    {{-- USER --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg justify-content-between"
                            href="{{ route('user.index') }}">
                            <div class="d-flex align-items-center gap-6">
                                <span class="d-flex">
                                    <iconify-icon icon="solar:user-id-line-duotone"></iconify-icon>
                                </span>
                                <span class="hide-menu">User</span>
                            </div>
                        </a>
                    </li>

                    {{-- WARGA --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg justify-content-between"
                            href="{{ route('warga.index') }}">
                            <div class="d-flex align-items-center gap-6">
                                <span class="d-flex">
                                    <iconify-icon icon="solar:users-group-two-rounded-line-duotone"></iconify-icon>
                                </span>
                                <span class="hide-menu">Warga</span>
                            </div>
                        </a>
                    </li>

                    {{-- KELUARGA KK --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg justify-content-between has-arrow"
                            href="javascript:void(0)">
                            <div class="d-flex align-items-center gap-6">
                                <span class="d-flex">
                                    <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                                </span>
                                <span class="hide-menu">Keluarga KK</span>
                            </div>
                        </a>

                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a class="sidebar-link primary-hover-bg justify-content-between"
                                    href="{{ route('keluarga_kk.index') }}">
                                    <div class="d-flex align-items-center gap-6">
                                        <span class="d-flex"><span class="icon-small"></span></span>
                                        <span class="hide-menu">Data Kepala KK</span>
                                    </div>
                                </a>
                            </li>

                            <li class="sidebar-item">
                                <a class="sidebar-link primary-hover-bg justify-content-between"
                                    href="{{ route('anggota_keluarga.index') }}">
                                    <div class="d-flex align-items-center gap-6">
                                        <span class="d-flex"><span class="icon-small"></span></span>
                                        <span class="hide-menu">Anggota Keluarga</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- KELAHIRAN --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg justify-content-between has-arrow"
                            href="javascript:void(0)">
                            <div class="d-flex align-items-center gap-6">
                                <span class="d-flex">
                                    <iconify-icon icon="mdi:baby-face-outline" width="20"
                                        height="20"></iconify-icon>
                                </span>
                                <span class="hide-menu">Kelahiran</span>
                            </div>
                        </a>

                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a class="sidebar-link primary-hover-bg justify-content-between"
                                    href="{{ route('peristiwa_kelahiran.index') }}">
                                    <div class="d-flex align-items-center gap-6">
                                        <span class="d-flex">
                                            <iconify-icon icon="mdi:clipboard-text-outline" width="19"
                                                height="19"></iconify-icon>
                                        </span>
                                        <span class="hide-menu">Data Kelahiran</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- KEMATIAN --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg justify-content-between has-arrow"
                            href="javascript:void(0)">
                            <div class="d-flex align-items-center gap-6">
                                <span class="d-flex">
                                    <iconify-icon icon="mdi:skull-outline" width="20" height="20"></iconify-icon>
                                </span>
                                <span class="hide-menu">Kematian</span>
                            </div>
                        </a>

                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a class="sidebar-link primary-hover-bg justify-content-between"
                                    href="{{ route('peristiwa_kematian.index') }}">
                                    <div class="d-flex align-items-center gap-6">
                                        <span class="d-flex">
                                            <iconify-icon icon="mdi:clipboard-text-clock-outline" width="19"
                                                height="19"></iconify-icon>
                                        </span>
                                        <span class="hide-menu">Data Kematian</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- PINDAH --}}
                    <li class="sidebar-item">
                        <a class="sidebar-link primary-hover-bg justify-content-between has-arrow"
                            href="javascript:void(0)">
                            <div class="d-flex align-items-center gap-6">
                                <span class="d-flex">
                                    <iconify-icon icon="mdi:truck-fast-outline" width="20"
                                        height="20"></iconify-icon>
                                </span>
                                <span class="hide-menu">Pindah</span>
                            </div>
                        </a>

                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a class="sidebar-link primary-hover-bg justify-content-between"
                                    href="{{ route('peristiwa_pindah.index') }}">
                                    <div class="d-flex align-items-center gap-6">
                                        <span class="d-flex">
                                            <iconify-icon icon="mdi:clipboard-list-outline" width="19"
                                                height="19"></iconify-icon>
                                        </span>
                                        <span class="hide-menu">Data Pindah</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </div>
    @endif

</aside>
