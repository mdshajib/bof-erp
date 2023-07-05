@section('page-title')
    Login
@endsection
<div class="col-xxl-3 col-lg-4 col-md-5">
    <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100">
            <div class="d-flex flex-column h-100">
                <div class="mb-0 mb-md-1 text-center">
                    <a href="" class="d-block auth-logo">
                        <img
                            src="{{url('/')}}/assets/images/bof.png" alt="" height="90">
                        <span class="logo-txt d-block mt-3">{{ config('app.name') }}</span>
                    </a>
                </div>
                <div class="auth-content my-auto">
                    <div class="text-center">
                        <h5 class="mb-0">Welcome Back !</h5>
                        <p class="text-muted mt-2">Sign in to continue to {{ config('app.name') }}.</p>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ __(session('error')) }}
                        </div>
                    @endif
                    <form class="mt-2 pt-2 needs-validation" wire:submit.prevent="doLogin">
                        @csrf
                        <div class="mb-3 @error('email') has-danger @enderror">
                            <label for="email" class="form-label">{{ __('Email address') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="{{ __('Enter email address') }}"
                                wire:model.defer="email"
                            >
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <label fro="password" class="form-label">{{ __('Password') }}</label>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="">
                                        <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group auth-pass-inputgroup">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Enter password"
                                    aria-label="Password"
                                    aria-describedby="password-addon"
                                    wire:model.defer="password"
                                >
                                <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" name="remember" type="checkbox" id="remember-check">
                                    <label class="form-check-label" for="remember-check">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 waves-effect waves-light" wire:loading.attr="disabled">
                                <div wire:loading>
                                    <i class="fas fa-spin fa-spinner mr-2"></i>
                                </div>
                                Log In
                            </button>
                        </div>
                    </form>
                </div>
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> {{ config('app.name') }}   .</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end auth full page content -->
</div>

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
@once
    @push('footer')
        <script>
            $("#password-addon").on("click",function(){0<$(this).siblings("input").length&&("password"==$(this).siblings("input").attr("type")?$(this).siblings("input").attr("type","input"):$(this).siblings("input").attr("type","password"))});
        </script>
    @endpush
@endonce
