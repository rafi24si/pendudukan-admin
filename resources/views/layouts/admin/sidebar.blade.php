<aside class="left-sidebar">

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
                    <a class="sidebar-link primary-hover-bg justify-content-between" href="{{ route('user.index') }}"
                        aria-expanded="false">
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
                    <a class="sidebar-link primary-hover-bg justify-content-between" href="{{ route('warga.index') }}"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="solar:users-group-two-rounded-line-duotone"></iconify-icon>
                            </span>
                            <span class="hide-menu">Warga</span>
                        </div>
                    </a>
                </li>

                {{-- KELUARGA KK --}}
                {{-- MENU KELUARGA KK (INDUK) --}}
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg justify-content-between has-arrow" href="javascript:void(0)"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                            </span>
                            <span class="hide-menu">Keluarga KK</span>
                        </div>
                    </a>

                    {{-- SUBMENU --}}
                    <ul aria-expanded="false" class="collapse first-level">

                        {{-- DATA KK --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link primary-hover-bg justify-content-between"
                                href="{{ route('keluarga_kk.index') }}">
                                <div class="d-flex align-items-center gap-6">
                                    <span class="d-flex"><span class="icon-small"></span></span>
                                    <span class="hide-menu">Data Kepala KK</span>
                                </div>
                            </a>
                        </li>

                        {{-- ANGGOTA KELUARGA --}}
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

                {{-- MENU PERISTIWA KELAHIRAN --}}
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg justify-content-between has-arrow" href="javascript:void(0)"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="mdi:baby-face-outline" width="20" height="20"></iconify-icon>
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

                {{-- MENU PERISTIWA KEMATIAN --}}
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg justify-content-between has-arrow" href="javascript:void(0)"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="mdi:skull-outline" width="20" height="20"></iconify-icon>
                            </span>
                            <span class="hide-menu">Kematian</span>
                        </div>
                    </a>

                    <ul aria-expanded="false" class="collapse first-level">

                        {{-- DATA KEMATIAN --}}
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

                {{-- MENU PERISTIWA PINDAH --}}
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg justify-content-between has-arrow"
                        href="javascript:void(0)" aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="mdi:truck-fast-outline" width="20"
                                    height="20"></iconify-icon>
                            </span>
                            <span class="hide-menu">Pindah</span>
                        </div>
                    </a>

                    <ul aria-expanded="false" class="collapse first-level">

                        {{-- DATA PERISTIWA PINDAH --}}
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

</aside>
