@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('header')
    <x-common.header title="{{ __('Dashboard') }}">

    </x-common.header>
@endsection

<div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100 border border-primary text-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <span class=" mb-3 lh-1 d-block text-truncate">Today's Sales</span>
                            <h4 class="mb-3 text-primary">
{{--                                @php $n = NumberToBangla::bnNum(213); @endphp--}}
                                ৳<span class="counter-value" data-target="{{ $day['current_day'] }}">0</span>
                            </h4>
                        </div>
                    </div>
                    <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">৳ {{ $day['last_day'] }} </span>
                        <span class="ms-1 font-size-13">Last Day</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100 border border-danger text-danger">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <span class=" mb-3 lh-1 d-block text-truncate ">Weekly Sales</span>
                            <h4 class="mb-3 text-danger">
                                ৳<span class="counter-value" data-target="{{ $weekly['current_week'] }}">0</span>
                            </h4>
                        </div>
                    </div>
                    <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">৳ {{ $weekly['last_week'] }}</span>
                        <span class="ms-1 font-size-13">Last Week</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100 border border-success">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <span class="mb-3 lh-1 d-block text-truncate text-success">This Month Sales</span>
                            <h4 class="mb-3 text-success">
                                ৳<span class="counter-value text-success" data-target="{{ $month['current_month'] }}">0</span>
                            </h4>
                        </div>
                    </div>
                    <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">৳ {{ $month['last_month'] }}</span>
                        <span class="ms-1 text-muted font-size-13 text-success">Last Month sales</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-h-100 border border-info text-info">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <span class=" mb-3 lh-1 d-block text-truncate">This Year Sales</span>
                            <h4 class="mb-3 text-info">
                                ৳<span class="counter-value" data-target="{{ $year['current_year'] }}">0</span>
                            </h4>
                        </div>
                    </div>
                    <div class="text-nowrap">
                        <span class="badge bg-soft-success text-success">৳ {{ $year['last_year'] }}</span>
                        <span class="ms-1 font-size-13">Last Year</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card card-h-100">
                <div class="card-body">
                    <div id="monthly_sales" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('footer')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
        monthlyBarChart();
    </script>
@endpush
