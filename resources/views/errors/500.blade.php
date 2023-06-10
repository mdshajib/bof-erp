@extends('layouts.public')


@section('content')
<!-- <body data-layout="horizontal"> -->

<div class="my-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <h1 class="display-1 fw-semibold">5<span class="text-primary mx-2">0</span>0</h1>
                    <h4 class="text-uppercase">Internal Server Error</h4>
                    <div class="mt-5 text-center">
                        <a class="btn btn-primary waves-effect waves-light" href="{{url('/')}}">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 col-xl-8">
                <div>
                    <img src="{{url('/')}}/assets/images/error-img.png" alt="" class="img-fluid">
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end content -->
@endsection
