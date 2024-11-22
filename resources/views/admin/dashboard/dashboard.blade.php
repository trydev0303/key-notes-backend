@extends('admin.layouts.master')

@section('title')
    Key-Notes | Dashboard
@endsection

@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Dashboard</h3>
            </div>
        </div>
    </div>

    <!-- end:: Content Head -->

    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <div class="row">
            <div class="col-xl-4 col-lg-4 order-lg-2">
                <div class="kt-portlet kt-portlet--height-fluid kt-padding-20">
                    <div class="kt-portlet__body kt-portlet__body--fit-y">
                        <div class="kt-widget kt-widget--user-profile-4">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden-">
                                        <i class="fa fa-user-friends w-icon"></i>
                                    </div>
                                </div>
                                <div class="kt-widget__content text-center">
                                    <div class="kt-widget__section">
                                        <span class="kt-widget__username">
                                            Total Users
                                        </span>
                                        <span class="kt-widget__score">
                                            {{ $allUsers }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 order-lg-2">
                <div class="kt-portlet kt-portlet--height-fluid kt-padding-20">
                    <div class="kt-portlet__body kt-portlet__body--fit-y">
                        <div class="kt-widget kt-widget--user-profile-4">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden-">
                                        <i class="fa fa-user-check w-icon"></i>
                                    </div>
                                </div>
                                <div class="kt-widget__content text-center">
                                    <div class="kt-widget__section">
                                        <span class="kt-widget__username">
                                            Total Paid Users
                                        </span>
                                        <span class="kt-widget__score">
                                            {{ $paidUsers }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 order-lg-2">
                <div class="kt-portlet kt-portlet--height-fluid kt-padding-20">
                    <div class="kt-portlet__body kt-portlet__body--fit-y">
                        <div class="kt-widget kt-widget--user-profile-4">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden-">
                                        <i class="fa fa-user-friends w-icon"></i>
                                    </div>
                                </div>
                                <div class="kt-widget__content text-center">
                                    <div class="kt-widget__section">
                                        <span class="kt-widget__username">
                                            Total Free Users
                                        </span>
                                        <span class="kt-widget__score">
                                            {{ $allUsers }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 order-lg-2">

                <!--begin:: Widgets/Profit Share-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                    <div class="widget widget-chart-two">
                            <div class="widget-heading">
                                <h5 class="">Total Users</h5>
                            </div>
                            <div class="widget-content">
                                <div id="total-user" class=""></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end:: Widgets/Profit Share-->
            </div>
            <div class="col-xl-6 col-lg-6 order-lg-2">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                    <div class="widget widget-chart-two">
                        <div class="widget-heading">
                            <h5 class="">Total Subscribers</h5>
                        </div>
                        <div class="widget-content">
                            <div id="total-subscribers" class=""></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xl-6 col-lg-6 order-lg-2">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header">
                            <h3 class="kt-widget14__title">
                                Revenue Change
                            </h3>
                            <span class="kt-widget14__desc">
                                Revenue change breakdown by cities
                            </span>
                        </div>
                        <div class="kt-widget14__content">
                            <div class="kt-widget14__chart">
                                <div id="kt_chart_revenue_change" style="height: 150px; width: 150px;"></div>
                            </div>
                            <div class="kt-widget14__legends">
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-success"></span>
                                    <span class="kt-widget14__stats">+10% New York</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-warning"></span>
                                    <span class="kt-widget14__stats">-7% London</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-brand"></span>
                                    <span class="kt-widget14__stats">+20% California</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <!--End::Row-->

        <!--End::Dashboard 1-->
    </div>

    <!-- end:: Content -->
@endsection
<!-- monthly registration script start -->
@section('script')

<script>
    var options = {
        chart: {
            type: 'donut',
            width: 400,
            height: 350
        },
        colors: ['#5d78ff', '#ffb822', '#e7515a', '#e2a03f'],
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
                offsetX: -5,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 30
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '26px',
                            fontFamily: 'Nunito, sans-serif',
                            color: undefined,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '26px',
                            fontFamily: 'Nunito, sans-serif',
                            color: '#0e1726',
                            offsetY: 16,
                            formatter: function(val) {
                                return val
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            color: '#888ea8',
                            fontSize: '30px',
                            formatter: function(w) {
                                return w.globals.seriesTotals.reduce(function(a, b) {
                                    return a + b
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
        stroke: {
            show: true,
            width: 15,
            colors: '#fff'
        },
        series: [{{ $allActiveUsers }}, {{ $allInactiveUsers }}],
        labels: ['Active Users', 'In Active Users'],

        responsive: [{
                breakpoint: 1440,
                options: {
                    chart: {
                        width: 325
                    },
                }
            },
            {
                breakpoint: 1199,
                options: {
                    chart: {
                        width: 380
                    },
                }
            },
            {
                breakpoint: 575,
                options: {
                    chart: {
                        width: 320
                    },
                }
            },
        ],
    }
    var chart = new ApexCharts(
        document.querySelector("#total-user"),
        options
    );

    chart.render();
</script>
<script>
    var options = {
        chart: {
            type: 'donut',
            width: 400,
            height: 350
        },
        colors: ['#5d78ff', '#ffb822', '#e7515a', '#e2a03f'],
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
                offsetX: -5,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 30
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '26px',
                            fontFamily: 'Nunito, sans-serif',
                            color: undefined,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '26px',
                            fontFamily: 'Nunito, sans-serif',
                            color: '#0e1726',
                            offsetY: 16,
                            formatter: function(val) {
                                return val
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total',
                            color: '#888ea8',
                            fontSize: '30px',
                            formatter: function(w) {
                                return w.globals.seriesTotals.reduce(function(a, b) {
                                    return a + b
                                }, 0)
                            }
                        }
                    }
                }
            }
        },
        stroke: {
            show: true,
            width: 15,
            colors: '#fff'
        },
        series: [{{ $paidSubscribers }}, {{ $freeSubscribers }}],
        labels: ['Paid Users', 'Free Users'],

        responsive: [{
                breakpoint: 1440,
                options: {
                    chart: {
                        width: 325
                    },
                }
            },
            {
                breakpoint: 1199,
                options: {
                    chart: {
                        width: 380
                    },
                }
            },
            {
                breakpoint: 575,
                options: {
                    chart: {
                        width: 320
                    },
                }
            },
        ],
    }
    var chart = new ApexCharts(
        document.querySelector("#total-subscribers"),
        options
    );

    chart.render();
</script>

@endsection

<!-- monthly registration script end -->
