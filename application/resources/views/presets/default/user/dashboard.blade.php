@extends($activeTemplate.'layouts.master')
@section('content')
<div class="dashboard py-80 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                @include($activeTemplate.'components.sidebar')
            </div>


            <div class="col-xl-9 col-lg-12">
                <div class="dashboard-body">
                    <div class="dashboard-body__bar">
                        <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
                    </div>
                    <div class="row gy-4 justify-content-center">
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <div class="dashboard-card">
                                <div class="dashboard-card__icon">
                                    <i class="las la-wallet"></i>
                                </div>
                                <div class="dashboard-card__content">
                                    <h5 class="dashboard-card__title">@lang('Balance')</h5>
                                    <h4 class="dashboard-card__amount">{{showAmount($user['balance'])}} {{__($general->cur_text)}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <a class="d-block" href="{{route('user.deposit.history')}}">
                                <div class="dashboard-card">
                                    <div class="dashboard-card__icon">
                                        <i class="las la-info-circle"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Pending Balances')</h5>
                                        <h4 class="dashboard-card__amount">{{__($user['deposit_pending'])}}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <a class="d-block" href="{{route('user.withdraw.history')}}">
                                    <div class="dashboard-card">
                                        <div class="dashboard-card__icon">
                                            <i class="las la-file-invoice-dollar"></i>
                                        </div>
                                        <div class="dashboard-card__content">
                                            <h5 class="dashboard-card__title">@lang('Pending Withdrawal')</h5>
                                            <h4 class="dashboard-card__amount">{{__($user['withdraw_pending'])}}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <a class="d-block" href="{{route('user.podcast.list')}}">
                                <div class="dashboard-card ">
                                    <div class="dashboard-card__icon">
                                        <i class="la la-podcast"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Total Podcast')</h5>
                                        <h4 class="dashboard-card__amount">{{__($count['podcasts'])}}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <a class="d-block" href="{{route('user.podcast.episodes.list')}}">
                                <div class="dashboard-card">
                                    <div class="dashboard-card__icon">
                                        <i class="las la-play-circle"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Total Episode')</h5>
                                        <h4 class="dashboard-card__amount">{{__($count['episodes'])}}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-sm-6">
                            <a class="d-block" href="{{route('user.podcast.episodes.list')}}">
                                <div class="dashboard-card">
                                    <div class="dashboard-card__icon">
                                        <i class="las la-headphones"></i>
                                    </div>
                                    <div class="dashboard-card__content">
                                        <h5 class="dashboard-card__title">@lang('Total Listening')</h5>
                                        <h4 class="dashboard-card__amount">{{__($total_listens)}}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>


                    </div>


                    <div class="row mt-3">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">@lang('Episode Listening Report')</h5>
                                    <div id="episode-listening-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>


        </div>


    </div>
</div>
@endsection

@push('script')
<script src="{{asset('assets/admin/js/apexcharts.min.js')}}"></script>

<script>
    "use strict";

(function () {
        var options = {
            series: [{
                name: "Listening Episode",
                data: @json($episode['values'])
    }],
    chart: {
        height: '310px',
            type: 'area',
                zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    colors: ['#7e61ff'],
        labels: @json($episode['labels']),
    xaxis: {
        type: 'date',
            },
    yaxis: {
        opposite: true
    },
    legend: {
        horizontalAlign: 'left'
    }
        };

    var chart = new ApexCharts(document.querySelector("#episode-listening-chart"), options);
    chart.render();
    }) ();

</script>



@endpush
