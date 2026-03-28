<div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">

    <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
        <a class="d-flex justify-content-center" href="#" target="_blank">
            <img src="{{ asset('assets/images/soa.png') }}" alt="Logo Kependudukan" style="height:60px;">
        </a>


        <div class="d-none d-xl-flex align-items-center gap-3">
            <a href="https://support.wrappixel.com/"
                class="btn btn-outline-primary d-flex align-items-center gap-1 border-0 text-white px-6">
                <i class="ti ti-lifebuoy fs-5"></i> Support
            </a>

            <a href="https://www.wrappixel.com/"
                class="btn btn-outline-primary d-flex align-items-center gap-1 border-0 text-white px-6">
                <i class="ti ti-gift fs-5"></i>
            </a>

            <a href="https://www.wrappixel.com/hire-us/"
                class="btn btn-outline-primary d-flex align-items-center gap-1 border-0 text-white px-6">
                <i class="ti ti-briefcase fs-5"></i> Hire Us
            </a>
        </div>
    </div>

    {{-- LOGIN / USERNAME + LOGOUT --}}
    <div class="d-flex align-items-center gap-3 ms-auto">

        @if (session()->has('nama_ic'))
            {{-- PROFILE --}}
            <div class="d-flex align-items-center gap-2 text-white">

                {{-- AVATAR --}}
                <div class="bg-light text-dark rounded-circle d-flex align-items-center justify-content-center"
                    style="width:40px;height:40px;font-weight:bold;">
                    {{ strtoupper(substr(session('nama_ic'), 0, 1)) }}
                </div>

                {{-- INFO --}}
                <div class="d-flex flex-column" style="line-height:1;">
                    <span class="fw-semibold">
                        {{ session('nama_ic') }}
                    </span>

                    <small class="text-warning">
                        {{ session('user_role') === 'petinggi' ? 'Petinggi' : 'Member' }}
                    </small>
                </div>
            </div>

            {{-- LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>
        @else
            {{-- LOGIN --}}
            <a href="{{ route('login.index') }}" class="btn btn-secondary d-flex align-items-center gap-2 px-4">
                <i class="ti ti-login fs-5"></i>
                Login
            </a>
        @endif

    </div>

</div>


<div class="d-lg-flex align-items-center gap-2">

    <div class="d-flex align-items-center justify-content-center gap-2">

        <div class="dropdown d-flex">
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop3">
                <div class="message-body">
                    <a target="_blank"
                        href="https://www.wrappixel.com/templates/spike-bootstrap-admin-dashboard/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        Bootstrap Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-angular-admin-template/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        Angular Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-vuejs-admin-dashboard/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        VueJs Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-nextjs-admin-template/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        NextJs Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-nextjs-admin-template/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        Tailwind Preview
                    </a>
                </div>
            </div>
        </div>

        <div class="dropdown d-flex">
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop4">
                <div class="message-body">
                    <a target="_blank"
                        href="https://www.wrappixel.com/templates/spike-bootstrap-admin-dashboard/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        Bootstrap Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-angular-admin-template/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        Angular Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-vuejs-admin-dashboard/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        VueJs Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-nextjs-admin-template/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        NextJs Preview
                    </a>
                    <a target="_blank" href="https://www.wrappixel.com/templates/spike-nextjs-admin-template/?ref=376"
                        class="dropdown-item d-flex align-items-center gap-1">
                        <i class="ti ti-external-link fs-5"></i>
                        Tailwind Preview
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
