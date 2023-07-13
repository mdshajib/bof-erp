<!doctype html>
<html lang="en">

    <head>
        <meta charset="{{ str_replace('_', '-', app()->getLocale()) }}" />
        <title>{{ config('app.name', 'Laravel') }} | @yield('page-title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="BOF ERP" name="description" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{url('/')}}/assets/images/favicon.ico">
        <!-- filepond css --->
		<link href="{{ asset('assets/libs/filepond/css/filepond.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/libs/filepond/css/filepond-plugin-image-preview.css')}}" rel="stylesheet">
        <!-- dropzone -->
        <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- choices css -->
        <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- twitter-bootstrap-wizard css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.css') }}">
        <!-- Sweet Alert-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- datepicker css -->
        <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- preloader css -->
        <link rel="stylesheet" href="{{ asset('assets/css/preloader.css') }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/metismenu/metisMenu.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/simplebar/simplebar.min.css') }}">

        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.css') }}?2" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/select2-bootstrap-5-theme/select2-bootstrap-5-theme.min.css') }}">

        <!-- Custom Css -->
        <link href="{{ asset('assets/css/custom.css') }}?2" id="app-style" rel="stylesheet" type="text/css" />
        <style>
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
            </style>

        @livewireStyles

        <style>

            table>thead .sorting,
            table>thead .sorting_asc,
            table>thead .sorting_desc,
            table>thead .sorting_asc_disabled,
            table>thead .sorting_desc_disabled {
                cursor: pointer;
                position: relative;
            }

            table>thead th.sorting::after,
            table>thead th.sorting_asc::after,
            table>thead th.sorting_asc_disabled::after,
            table>thead th.sorting_desc::after,
            table>thead th.sorting_desc_disabled::after,
            {
                right: .5em;
                left: auto;
            }

            table>thead th.sorting::after,
            table>thead th.sorting_asc::after,
            table>thead th.sorting_desc::after,
            table>thead th.sorting_asc_disabled::after,
            table>thead th.sorting_desc_disabled::after {
                right: 0.5em;
                content: "↓";
            }

            table>thead th.sorting:before,
            table>thead th.sorting:after,
            table>thead th.sorting_asc:before,
            table>thead th.sorting_asc:after,
            table>thead th.sorting_desc:before,
            table>thead th.sorting_desc:after,
            table>thead th.sorting_asc_disabled:before,
            table>thead th.sorting_asc_disabled:after,
            table>thead th.sorting_desc_disabled:before,
            table>thead th.sorting_desc_disabled:after {
                position: absolute;
                bottom: .9em;
                display: block;
                opacity: .3;
            }

            table>thead th.sorting::before,
            table>thead th.sorting_asc::before,
            table>thead th.sorting_asc_disabled::before,
            table>thead th.sorting_desc::before,
            table>thead th.sorting_desc_disabled::before {
                right: 1em;
                left: auto;
            }

            table>thead th.sorting::before,
            table>thead th.sorting_asc::before,
            table>thead th.sorting_desc::before,
            table>thead th.sorting_asc_disabled::before,
            table>thead th.sorting_desc_disabled::before {
                right: 1em;
                content: "↑";
            }

            table>thead th.sorting_asc:before,
            table>thead th.sorting_desc:after {
                opacity: 1;
            }
        </style>

        @stack('header')
    </head>

    <body class="pace-done modal-open">
        <div class="pace pace-inactive">
            <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
          </div>

        <div class="pace-activity"></div></div>
    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            <x-common.top-nav />

            <!-- Left Sidebar Start -->
            <x-common.aside />
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        @yield('header')
                        <!-- end page title -->

                        <x-common.alert />

                        <div class="row">
                            <div class="col-12">
                                @yield('content')
                            </div>
                        </div>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <x-common.footer />
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <x-common.right />

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/waves.min.js') }}"></script>
        <script src="{{ asset('assets/feather-icons/feather.min.js') }}"></script>
        <!-- pace js -->
        <script src="{{ asset('assets/js/pace.min.js') }}"></script>

        <!-- apexcharts -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- choices js -->
        <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
        <!-- twitter-bootstrap-wizard js -->
        <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
        <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
		<!-- init js
        <script src="{{ asset('assets/js/form-advanced.init.js') }}"></script>  -->
        <!-- form wizard init -->
        <script src="{{ asset('assets/js/form-wizard.init.js') }}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- datepicker js -->
        <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
        <!-- dropzone js -->
        <script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <!-- Alpine js 3 -->
        <script defer src="{{ asset('assets/js/alpinejs@3.2.4_dist_cdn.min.js') }}"></script>
{{--        <script defer src="https://unpkg.com/alpinejs@3.2.4/dist/cdn.min.js"></script>--}}
        <!-- filepond js --->
        <script src="{{ asset('assets/libs/filepond/js/filepond-plugin-file-validate-type.js')}}"></script>
        <script src="{{ asset('assets/libs/filepond/js/filepond-plugin-file-validate-size.js')}}"></script>
        <script src="{{ asset('assets/libs/filepond/js/filepond-plugin-image-validate-size.js')}}"></script>
        <script src="{{ asset('assets/libs/filepond/js/filepond-plugin-image-preview.js')}}"></script>
        <script src="{{ asset('assets/libs/filepond/js/filepond.js')}}"></script>
        <script src="{{ asset('assets/libs/select2/js/select2.full.min.js')}}"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.registerPlugin(FilePondPluginImageValidateSize);
        </script>

        @livewireScripts

        @include('layouts._alert-script')

        @stack('footer')

    </body>
</html>
