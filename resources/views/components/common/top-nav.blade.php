<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{url('/')}}/assets/images/bof.png" alt="" height="42">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url('/')}}/assets/images/bof.png" alt="" height="42"> <span class="logo-txt">{{ config('app.name') }}</span>
                    </span>
                </a>

                <a href="#" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{url('/')}}/assets/images/bof.png" alt="" height="42">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url('/')}}/assets/images/bof.png" alt="" height="42"> <span class="logo-txt">{{ config('app.name') }}</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ auth()->user()->profile_photo_url }}"
                        alt="{{ auth()->user()->full_name }}">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a
                            class="dropdown-item"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();"
                          >
                          <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> {{ __('Logout') }}
                        </a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
