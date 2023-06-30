<!doctype html>
<html lang="en">

    <head>

        <meta charset="{{ str_replace('_', '-', app()->getLocale()) }}" />
        <title>{{ config('app.name', 'Laravel') }} | @yield('page-title', 'Dashboard')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="BOF ERP" name="description" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{url('/')}}/assets/images/favicon.ico">

        <!-- preloader css -->
        <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        {{-- <link rel="stylesheet" href="{{ asset('assets/metismenu/metisMenu.min.css') }}"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('assets/simplebar/simplebar.min.css') }}"> --}}

        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        @livewireStyles
        <style>
		.auth-bg {
			  background-image: url(/images/auth-image.jpg);
			  background-position: center;
			  background-size: cover;
			  background-repeat: no-repeat;
			}
            #sidebar-menu .mm-active > .has-arrow:after {
                transform: rotate(-133deg);
            }

            #sidebar-menu .has-arrow:after {
                content:"";
                display: block;
                float: right;
                transition: transform 0.2s;
                font-size: .9rem;
                margin-right: 5px;
                margin-top: -2px;
            }

            .metismenu .has-arrow::after {
                transform: rotate(135deg) translate(0, -50%);
            }
            .btn-light{
                padding: 0.47rem 0.75rem;
            }
        </style>
        @stack('header')
    </head>

    <body>

        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    @yield('content')
                </div>
            </div>
        </div>


        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <!-- <script src="{{ asset('assets/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/waves.min.js') }}"></script>
        <script src="{{ asset('assets/feather-icons/feather.min.js') }}"></script>  -->
        <!-- pace js -->
        <script src="{{ asset('assets/js/pace.min.js') }}"></script>

        <!-- <script src="{{ asset('assets/js/app.js') }}"></script> -->

        @livewireScripts

    @include('layouts._alert-script')

        @stack('footer')

    </body>
</html>
