@extends('layouts.admin')
@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                    <a href="{{route('common.jobs.index')}}">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Jobs</h6>
                                <h3>{{$total_job}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">card_travel</i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Candidates</h6>
                                <h3>{{$total_candidate}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">person</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Applied Jobs</h6>
                                <h3>{{$total_applied_job}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">event_note</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Vendors</h6>
                                <h3>{{$total_vendor}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">supervisor_account</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Departments</h6>
                                <h3>{{$total_department}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons success font-large-2 float-right">business</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Designations</h6>
                                <h3>{{$total_designation}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons success font-large-2 float-right">school</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row">
            <div class="col-xl-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Revenue</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body pt-0">
                            <div class="row mb-1">
                                <div class="col-6 col-md-4">
                                    <h5>Current week</h5>
                                    <h2 class="danger">$82,124</h2>
                                </div>
                                <div class="col-6 col-md-4">
                                    <h5>Previous week</h5>
                                    <h2 class="text-muted">$52,502</h2>
                                </div>
                            </div>
                            <div class="chartjs">
                                <canvas id="thisYearRevenue" width="400" class="position-absolute"></canvas>
                                <canvas id="lastYearRevenue" width="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-12">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card pull-up">
                            <div class="card-header bg-hexagons">
                                <h4 class="card-title">Hit Rate <span class="danger">-12%</span></h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show bg-hexagons">
                                <div class="card-body pt-0">
                                    <div class="chartjs">
                                        <canvas id="hit-rate-doughnut" height="275"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content collapse show bg-gradient-directional-danger ">
                                <div class="card-body bg-hexagons-danger">
                                    <h4 class="card-title white">Deals <span class="white">-55%</span> <span
                                            class="float-right"><span class="white">152</span><span
                                                class="red lighten-4">/200</span></span>
                                    </h4>
                                    <div class="chartjs">
                                        <canvas id="deals-doughnut" height="275"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-muted">Order Value </h6>
                                            <h3>$ 88,568</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-trophy success font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-muted">Calls</h6>
                                            <h3>3,568</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="icon-call-in danger font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--/ Revenue, Hit Rate & Deals -->
        <!-- Emails Products & Avg Deals -->
        <!-- <div class="row">
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Emails</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body pt-0">
                            <p>Open rate <span class="float-right text-bold-600">89%</span></p>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-1">
                                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 80%"
                                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="pt-1">Sent <span class="float-right"><span
                                        class="text-bold-600">310</span>/500</span>
                            </p>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-1">
                                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 48%"
                                    aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Top Products</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a href="#">Show all</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="border-top-0">iPhone X</th>
                                            <td class="border-top-0 text-right">2245</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">One Plus</th>
                                            <td class="text-right">1850</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Samsung S7</th>
                                            <td class="text-right">1550</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Average Deal Size</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6 col-12 border-right-blue-grey border-right-lighten-5 text-center">
                                    <h6 class="danger text-bold-600">-30%</h6>
                                    <h4 class="font-large-2 text-bold-400">$12,536</h4>
                                    <p class="blue-grey lighten-2 mb-0">Per rep</p>
                                </div>
                                <div class="col-md-6 col-12 text-center">
                                    <h6 class="success text-bold-600">12%</h6>
                                    <h4 class="font-large-2 text-bold-400">$18,548</h4>
                                    <p class="blue-grey lighten-2 mb-0">Per team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--/ Emails Products & Avg Deals -->
        <!-- Total earning & Recent Sales  -->
        <div class="row">
            <!-- <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-content">
                        <div class="earning-chart position-relative">
                            <div class="chart-title position-absolute mt-2 ml-2">
                                <h1 class="display-4">$1,596</h1>
                                <span class="text-muted">Total Earning</span>
                            </div>
                            <canvas id="earning-chart" class="height-450"></canvas>
                            <div class="chart-stats position-absolute position-bottom-0 position-right-0 mb-2 mr-3">
                                <a href="#" class="btn round btn-danger mr-1 btn-glow">Statistics <i
                                        class="ft-bar-chart"></i></a> <span class="text-muted">for the <a href="#"
                                        class="danger darken-2">last year.</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div id="recent-sales" class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center text-danger">Recent Jobs</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="{{ route('common.jobs.index') }}" target="_blank">View all</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content mt-1">
                    <div class="table-responsive">
                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                            <thead>
                                <tr>
                                    <th class="border-top-0">Job Id</th>
                                    <th class="border-top-0">Title</th>
                                    <th class="border-top-0">Vacancy</th>
                                    <th class="border-top-0">Department</th>
                                    <th class="border-top-0">Designtion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_jobs as $recent_job)
                                
                                <tr>
                                    <td class="text-truncate"> {{$recent_job->jobid}}</td>
                                    <td class="text-truncate p-1">{{$recent_job->title}}</td>
                                    <td>{{$recent_job->no_of_vacancy}}</td>
                                    <td>{{$recent_job->departments->name}}</td>
                                    <td class="text-truncate">{{$recent_job->designations->name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/raphael-min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/morris.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('app-assets/data/jvector/visitor-data.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/material-app.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/dashboard-sales.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
    @endsection
