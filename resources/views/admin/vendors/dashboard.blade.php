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
                                <h3>{{$total_candidate_by_vendor}}</h3>
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