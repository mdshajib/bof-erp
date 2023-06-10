@extends('layouts.public')


@section('content')
    <div class="col-xxl-3 col-lg-4 col-md-5">
        <div class="auth-full-page-content d-flex p-sm-5 p-4">
            <div class="w-100">
                <div class="d-flex flex-column h-100">
                    <div class="mb-4 mb-md-5 text-center">
                        <a href="{{url('/')}}" class="d-block auth-logo">
                            <img
                                src="{{url('/')}}/assets/images/ViCAFE_Logo.svg" alt="" height="66">
                            <span class="logo-txt d-block mt-3">{{ config('app.name') }}</span>
                        </a>
                    </div>
                    <div class="auth-content my-auto">
                        <div class="text-center">
                            <h5 class="mb-0">Change Password</h5>
                            <p class="text-muted mt-2">Change your password now.</p>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success text-center my-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-success text-center my-4" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <form class="needs-validation mt-4 pt-2" action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" type="email" name="email" value="{{old('email', $request->email)}}" required autofocus>
                            <div class="mb-3">
                                <label for="password" class="form-label required">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required autocomplete="off">
                                <div class="invalid-feedback">
                                    Please Enter Password
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label required">Retype Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Retype Password" required autocomplete="off">
                                <div class="invalid-feedback">
                                    Please Enter Password
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Change Password</button>
                            </div>
                        </form>

                        <div class="mt-5 text-center">
                            <p class="text-muted mb-0">Already changed password? <a href="{{route('login')}}"
                                                                                    class="text-primary fw-semibold"> Login </a> </p>
                        </div>
                    </div>
                    <div class="mt-4 mt-md-5 text-center">
                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> {{ config('app.name') }}   .</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end auth full page content -->
    </div>
    <!-- end col -->
    <div class="col-xxl-9 col-lg-8 col-md-7">
        <div class="auth-bg pt-md-5 p-4 d-flex">
            <div class="bg-overlay bg-primary"></div>
            <ul class="bg-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <!-- end bubble effect -->
            <div class="row justify-content-center align-items-center">
                <div class="col-xl-7">
                    <div class="p-0 p-sm-4 px-xl-0">

                        <!-- end review carousel -->
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
