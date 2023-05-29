@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/morris.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/material-palette-gradient.min.css') }}">
@endsection
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
                                <h6 class="text-muted">Total Jobs</h6>
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
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                       <a href="{{route('common.approved_jobs')}}">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h6 class="text-muted">Approved Jobs</h6>
                                    <h3>{{$total_approved_job}}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="material-icons danger font-large-2 float-right">event_note</i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                    <a href="{{route('common.unapproved_jobs')}}">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Unapproved Jobs</h6>
                                <h3>{{$total_unapproved_job}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">event_note</i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Total Applied Jobs</h6>
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
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                    <a href="{{route('common.candidate.index')}}">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Candidates</h6>
                                <h3>{{$total_candidate -1}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">person</i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                    <a href="{{route('admin.vendor.index')}}">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Man-power Agency</h6>
                                <h3>{{$total_vendor}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">supervisor_account</i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                    <a href="{{route('admin.department.index')}}">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Departments</h6>
                                <h3>{{$total_department}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">business</i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                    <a href="{{route('admin.designation.index')}}">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h6 class="text-muted">Designations</h6>
                                <h3>{{$total_designation}}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="material-icons danger font-large-2 float-right">school</i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
                                        <i class="icon-trophy danger font-large-2 float-right"></i>
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
    <!--/ Revenue, Hit Rate & Deals-->
    <!-- Total earning & Recent Sales  -->
    <div class="row">
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
@endsection