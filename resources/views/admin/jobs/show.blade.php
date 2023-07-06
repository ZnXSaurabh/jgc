@extends('layouts.admin')
@section('styles')
<style>
    .content-wrapper {
        padding: 2.1rem 1rem 0 !important;
    }

    body .content-detached.content-right .content-body {
        margin-left: 275px !important;
    }

    img {
        width: 100%;
    }

    .sidebar {
        width: 250px !important;
    }

    .content-wrapper:before {
        content: "";
        clear: both;
        display: block;
    }

    .content-wrapper:after {
        content: "";
        clear: both;
        display: block;
    }

    .content-right:before {
        content: "";
        clear: both;
        display: block;
    }

    .content-right:after {
        content: "";
        clear: both;
        display: block;
    }

    .sidebar-left:before {
        content: "";
        clear: both;
        display: block;
    }

    .sidebar-left:after {
        content: "";
        clear: both;
        display: block;
    }

</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/extensions/rowReorder.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css') }}">
<!-- table Links -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/paper/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="{{ asset('filter-each-column/Filter.css')}}" rel="stylesheet">
<!-- end tables links -->
@endsection
@section('content')
<div class="content-detached content-right">
    <div class="content-body">
        <section class="row">
            <div class="col-12">
            @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Job Description</h4>
                        <div class="heading-elements">
                            <a class="btn btn-danger" href="{{ route('common.jobs.index') }}"><span
                                    class="material-icons">keyboard_backspace</span> Back</a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @if($job->attachment != NULL)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($job->attachment) }}">
                            @endif
                            {!! $job->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="sidebar-detached sidebar-left">
    <div class="sidebar">
        <div class="bug-list-sidebar-content">
            <!--  <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Job Info</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><span class="material-icons">minimize</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body ">
                        <div class="list-group">
                            <a href="#" class="list-group-item active">All Bugs</a>
                            <a href="#" class="list-group-item list-group-item-action">Bugs I Follow</a>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="card">
                <div class="card-header mb-0">
                    <h4 class="card-title">Job Info</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><span class="material-icons">minimize</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body  py-0 px-0">
                        <div class="list-group">
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Job ID</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->jobid }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1">
                                            <strong>{{ trans('global.job.fields.title') }}</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->title }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Department</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->departments->name }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Designation</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->designations->name }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Gender Preference</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->gender_preference }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Location Preference</strong></p>
                                        <h6 class="media-heading mb-0">{{$job->location_preference}}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Number of Vacancy</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->no_of_vacancy }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Minimum Experience</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->minimum_exp_req }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Minimum Qualification</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->minimum_qualification }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Location</strong></p>
                                        <h6 class="media-heading mb-0">
                                            {{ App\Models\Location::where('id', $job->location_id)->pluck('name')->first() }}
                                        </h6>
                                    </div>
                                </div>
                            </a>
                            @if($job->job_expiry_date )
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="font-small-2 mb-1"><strong>Job Expiry Date</strong></p>
                                        <h6 class="media-heading mb-0">
                                        {{ Carbon\Carbon::parse($job->job_expiry_date)->format('d-M-Y')   }}</h6>
                                    </div>
                                </div>
                            </a>
                            @endif
                            @can('job_approved')
                            @if($job->approved_by == NULL)
                            <a href="javascript:void(0)" class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <form action="{{ route('hr_manager.job_approve', $job->id) }}">
                                            <button class="btn btn-success" type="submit">Approve Job</button>
                                        </form>
                                        <!-- <p class="font-small-2 mb-1"><strong>Minimum Experience</strong></p>
                                        <h6 class="media-heading mb-0">{{ $job->minimum_exp_req }}</h6> -->
                                    </div>
                                </div>
                            </a>
                            @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="container-fluid">
    <div class="row">
        @if(Auth::user()->hasRole('Vendor'))
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Candiate List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body table-responsive">
                        <div class="panel panel-primary filterable">
                        <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-4 p-1">
                                            <form action="{{ route('common.notapplied_filter_by_exp') }}" method="post">
                                                @csrf
                                                <select class="form-control mr-1" style="width:50%;float:left" name="exp">
                                                    <option value=" ">Choose Experience</option>
                                                    <option value="1" @if('1' == $exp)
                                                    selected @endif>1</option>
                                                    <option value="2"@if('2' == $exp)
                                                    selected @endif>2</option>
                                                    <option value="3"@if('3' == $exp)
                                                    selected @endif>3</option>
                                                    <option value="4"@if('4' == $exp)
                                                    selected @endif>4</option>
                                                    <option value="5"@if('5' == $exp)
                                                    selected @endif>5</option>
                                                    <option value="6"@if('6' == $exp)
                                                    selected @endif>6</option>
                                                    <option value="7"@if('7' == $exp)
                                                    selected @endif>7</option>
                                                    <option value="8"@if('8' == $exp)
                                                    selected @endif>8</option>
                                                    <option value="9"@if('9' == $exp)
                                                    selected @endif>9</option>
                                                    <option value="10"@if('10' == $exp)
                                                    selected @endif>10</option>
                                                </select>
                                                <input type="hidden" name="jobid"value="{{$job->id}}">
                                                <button type="submit" class="btn btn-info mt-0">Filter By Experience</button>
                                            </form>
                                        </div>
                                        <div class="col-lg-4 p-1">
                                            <form action="{{ route('common.notapplied_filter_by_age') }}" method="post">
                                                @csrf
                                                <input type="number" name="age" value=" " min='0' style="width:150px" value="{{$age}}" placeholder="Enter Age here">
                                                <input type="hidden" name="jobid"value="{{$job->id}}">
                                                <button type="submit" class="btn btn-info mt-0">Filter By Age</button>
                                                <a href="{{route('common.jobs.show',$job->id)}}" style="padding: 0.425rem .5rem;" class=" mt-0 btn btn-success "><span class="material-icons">cached</span></a>
                                            </form>
                                        </div>
                                        <div class="col-lg-4">
                                            <h3 class="panel-title @if(!Auth::user()->hasRole('Vendor')) text-right @endif mb-0">
                                                <button class="btn btn-default btn-xs btn-filter mt-1"><span class="glyphicon glyphicon-filter"></span>Click To Apply Filter</button>
                                            </h3>
                                        </div>
                                    </div>
                                    @if($errors->has('job_id'))
                                                   <p class="text-danger">{{ $errors->first('job_id') }}</p>
                                                @endif
                                    @if($not_applied_candidates['candidate_detail'][0]->name== NULL )
                                    <h6 class="text-danger">No Result Found</h6>
                                    @endif
                                    </div>
                            <table class="table table-bordered table-striped">
                                <form action="{{ route('common.job_apply_by_vendor',$job->id) }}" method="post">
                                    @csrf
                                    <thead>
                                        <tr class="filters">
                                            <th style="width:10px;"><input type="text" class="form-control"
                                                    placeholder="Choose" disabled></th>
                                            <th><input type="text" class="form-control" placeholder="Name" disabled>
                                            </th>
                                            <th><input type="text" class="form-control" placeholder="Email" disabled>
                                            </th>
                                            <th><input type="text" class="form-control" placeholder="Age" disabled>
                                            </th>
                                            <th><input type="text" class="form-control" placeholder="Education"
                                                    disabled></th>
                                                    <th><input type="text" class="form-control" placeholder="Experience"
                                                    disabled></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($not_applied_candidates['candidate_detail'] as $key => $applied_job)
                                        <tr>
                                            <td><input type="checkbox" name="user_id[]" value="{{$not_applied_candidates['candidate_detail'][$key]->id}}"></td>
                                            <td><a class="btn btn-xs btn-info" target="_blank"
                                                    href="{{ route('common.candidate.show', $not_applied_candidates['candidate_detail'][$key]->id) }}">{{ $not_applied_candidates['candidate_detail'][$key]->name }}</a>
                                            </td>
                                            <td>{{$not_applied_candidates['candidate_detail'][$key]->email}}</td>
                                            @if(!Auth::user()->hasRole('Vendor'))
                                            <td>{{ \Carbon\Carbon::parse($not_applied_candidates['profile'][$key]->dob)->age  }}
                                            @else
                                            <td>{{ \Carbon\Carbon::parse($not_applied_candidates['candidate_detail'][$key]->dob)->age  }}
                                            @endif
                                            </td>
                                            <td>@foreach(json_decode($not_applied_candidates['candidate_edu'][$key]['course'],
                                                true) as $course){{ $course }}<br> @endforeach</td>
                                                <td>@foreach(json_decode($users['candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                    @php
                                                    $startTime = \Carbon\Carbon::parse($start_year);

                                                    $endTime = \Carbon\Carbon::parse(json_decode($users['candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                    @endphp
                                                @endforeach

                                                {{round($totalDuration/12,1).' Year'}}

                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @if(!Auth::user()->hasRole('HR Manager') || !Auth::user()->hasRole('HR'))
                                    <button class="btn btn-info" type="submit">Apply with candidate</button>
                                    @endif
                                </form>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Applied Candidates</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="panel panel-primary filterable">
                                    <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-4 p-1">
                                            <form action="{{ route('common.applied_filter_by_exp') }}" method="post">
                                                @csrf
                                                <?php
                                                $exp = null; // Assigning the value 3 to $exp

                                                ?>

                                                <select class="form-control mr-1" style="width:50%;float:left" name="exp">
                                                    <option value=" ">Choose Experience</option>
                                                    <option value="1" <?php if('1' == $exp) echo 'selected'; ?>>1</option>
                                                    <option value="2" <?php if('2' == $exp) echo 'selected'; ?>>2</option>
                                                    <option value="3" <?php if('3' == $exp) echo 'selected'; ?>>3</option>
                                                    <option value="4" <?php if('4' == $exp) echo 'selected'; ?>>4</option>
                                                    <option value="5" <?php if('5' == $exp) echo 'selected'; ?>>5</option>
                                                    <option value="6" <?php if('6' == $exp) echo 'selected'; ?>>6</option>
                                                    <option value="7" <?php if('7' == $exp) echo 'selected'; ?>>7</option>
                                                    <option value="8" <?php if('8' == $exp) echo 'selected'; ?>>8</option>
                                                    <option value="9" <?php if('9' == $exp) echo 'selected'; ?>>9</option>
                                                    <option value="10" <?php if('10' == $exp) echo 'selected'; ?>>10</option>
                                                </select>
                                                <input type="hidden" name="jobid"value="{{$job->id}}">
                                                <button type="submit" class="btn btn-info mt-0">Filter By Experience</button>
                                            </form>
                                        </div>
                                        <div class="col-lg-4 p-1">
                                            <form action="{{ route('common.applied_filter_by_age') }}" method="post">
                                                @csrf
                                                <input type="number" name="age" value=" " min='0' style="width:150px" value="{{$age}}" placeholder="Enter Age here">
                                                <input type="hidden" name="jobid"value="{{$job->id}}">
                                                <button type="submit" class="btn btn-info mt-0">Filter By Age</button>
                                                <a href="{{route('common.jobs.show',$job->id)}}" style="padding: 0.425rem .5rem;" class=" mt-0 btn btn-success "><span class="material-icons">cached</span></a>
                                            </form>
                                        </div>
                                        <div class="col-lg-4">
                                            <h3 class="panel-title @if(!Auth::user()->hasRole('Vendor')) text-right @endif mb-0">
                                                <button class="btn btn-default btn-xs btn-filter mt-1"><span class="glyphicon glyphicon-filter"></span>Click To Apply Filter</button>
                                            </h3>
                                        </div>
                                    </div>
                                    @if($errors->has('job_id'))
                                                   <p class="text-danger">{{ $errors->first('job_id') }}</p>
                                                @endif


                                    @if(isset($applied_jobs['candidate_detail'][0]->name) && isset($applied_jobs['vendors_candidate_detail'][0]))
                                    @if($applied_jobs['candidate_detail'][0]->name == NULL && $applied_jobs['vendors_candidate_detail'][0] == NULL)
                                    <h6 class="text-danger">No Result Found</h6>
                                    @endif

                                @endif
                                    </div>
                                </div>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="filters">
                                                <th style="width:10px;"><input type="text" class="form-control"
                                                        placeholder="#" disabled></th>
                                                <th><input type="text" class="form-control" placeholder="Candidate"
                                                        disabled></th>
                                                        <th><input type="text" class="form-control" placeholder="Email"
                                                        disabled></th>
                                                <th><input type="text" class="form-control" placeholder="Age" disabled>
                                                </th>
                                                <th><input type="text" class="form-control" placeholder="Education"
                                                        disabled></th>
                                                        <th><input type="text" class="form-control" placeholder="Experience"
                                                        disabled></th>

                                                <th><input type="text" class="form-control" placeholder="Applied By"
                                                        disabled></th>
                                                <th><input type="text" class="form-control" placeholder="Applied Date"
                                                        disabled></th>
                                                        @can('job_shortlist_access')
                                                <th><input type="text" class="form-control" placeholder="Action"
                                                        disabled></th>
                                                        @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach($applied_jobs['candidate_detail'] as $key => $applied_job)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td><a class="" target="_blank"
                                                        href="{{ route('common.candidate.show', $applied_jobs['candidate_detail'][$key]->id) }}">{{ $applied_jobs['candidate_detail'][$key]->name }}</a>
                                                </td>
                                                <td>{{ $applied_jobs['candidate_detail'][$key]->email  }}
                                                </td>
                                                @if(!Auth::user()->hasRole('Vendor'))
                                                <td>{{ \Carbon\Carbon::parse($applied_jobs['profile'][$key]->dob)->age  }}
                                                </td>
                                                @else
                                                <td>{{ \Carbon\Carbon::parse($applied_jobs['candidate_detail'][$key]->dob)->age  }}
                                                </td>
                                                @endif
                                                <td>@foreach(json_decode($applied_jobs['candidate_edu'][$key]['course'],
                                                    true) as $course){{ $course }}<br> @endforeach</td>
                                                    @php $totalDuration = 0; @endphp
                                                <td>@foreach(json_decode($applied_jobs['candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                    @php
                                                    $startTime = \Carbon\Carbon::parse($start_year);

                                                    $endTime = \Carbon\Carbon::parse(json_decode($applied_jobs['candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                    @endphp
                                                    @endforeach
                                                    {{round($totalDuration/12,1).' Year'}}

                                                </td>


                                                @if($applied_jobs['appliedcandidates'][$key]->applied_by == NULL)
                                                <td>Candidate</td>
                                                @else
                                                <td><button type="button" class="btn btn-info btn-lg vendor_profile"
                                                        value="{{$applied_jobs['appliedcandidates'][$key]->applied_by}}"
                                                        data-toggle="modal" data-target="#myModal">Vendor</button></td>
                                                @endif
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $applied_jobs['appliedcandidates'][$key]->applied_date)->format('d-M-Y H:i:s') }}</td>
                                                @can('job_shortlist_access')
                                                <td><a class="btn btn-xs btn-success"
                                                        href="{{ route('common.shortlist', $applied_jobs['appliedcandidates'][$key]->id) }}"><svg
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="white" width="18px" height="18px">
                                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                                            <path
                                                                d="M12 20l-.86-.86c-1.18-1.18-1.17-3.1.02-4.26l.84-.82c-.39-.04-.68-.06-1-.06-2.67 0-8 1.34-8 4v2h9zm-1-8c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4" />
                                                            <path
                                                                d="M16.18 19.78c-.39.39-1.03.39-1.42 0l-2.07-2.09c-.38-.39-.38-1.01 0-1.39l.01-.01c.39-.39 1.02-.39 1.4 0l1.37 1.37 4.43-4.46c.39-.39 1.02-.39 1.41 0l.01.01c.38.39.38 1.01 0 1.39l-5.14 5.18z" />
                                                        </svg></a></td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                            @if(isset($applied_jobs['vendors_candidate_detail']) && count($applied_jobs['vendors_candidate_detail']) > 0)
                                            @if(isset($applied_jobs['vendors_candidate_detail'][0]->id) && $applied_jobs['vendors_candidate_detail'][0]->id != '')
                                              @if(!Auth::user()->hasRole('Vendor'))
                                             <tr><th colspan="9" class="text-center">Vendors Candidates</th></tr>
                                             @endif
                                            @endif
                                            @endif
                                            @foreach($applied_jobs['vendors_candidate_detail'] as $key => $applied_job)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                               
                                                <td><a class="" target="_blank"
                                                        href="{{ route('common.vendors_candidates_show', $applied_jobs['vendors_candidate_detail'][$key]->id) }}">{{ $applied_jobs['vendors_candidate_detail'][$key]->name }}</a>
                                                </td>
                                                <td>{{$applied_jobs['vendors_candidate_detail'][$key]->email  }}</td>
                                                <td>{{ \Carbon\Carbon::parse($applied_jobs['vendors_candidate_detail'][$key]->dob)->age}}</td>
                                             
                                                <td>@foreach(json_decode($applied_jobs['vendors_candidate_edu'][$key]['course'],
                                                    true) as $course){{ $course }}<br> @endforeach</td>
                                                    @php $totalDuration = 0; @endphp
                                                <td>@foreach(json_decode($applied_jobs['vendors_candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                    @php
                                                    $startTime = \Carbon\Carbon::parse($start_year);

                                                    $endTime = \Carbon\Carbon::parse(json_decode($applied_jobs['vendors_candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                    @endphp
                                                    
                                                @endforeach
                                                {{round($totalDuration/12,1).' Year'}}

                                                </td>

                                                @if($applied_jobs['vendors_appliedcandidates'][$key]->applied_by == NULL)
                                                <td>Candidate</td>
                                                @else
                                                <td><button type="button" class="btn btn-info btn-lg vendor_profile"
                                                        value="{{$applied_jobs['vendors_appliedcandidates'][$key]->applied_by}}"
                                                        data-toggle="modal" data-target="#myModal">Vendor</button></td>
                                                @endif
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $applied_jobs['vendors_appliedcandidates'][$key]->applied_date)->format('d-M-Y H:i:s') }}</td>
                                                @can('job_shortlist_access')
                                                <td><a class="btn btn-xs btn-success"
                                                        href="{{ route('common.shortlist', $applied_jobs['vendors_appliedcandidates'][$key]->id) }}"><svg
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="white" width="18px" height="18px">
                                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                                            <path
                                                                d="M12 20l-.86-.86c-1.18-1.18-1.17-3.1.02-4.26l.84-.82c-.39-.04-.68-.06-1-.06-2.67 0-8 1.34-8 4v2h9zm-1-8c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4" />
                                                            <path
                                                                d="M16.18 19.78c-.39.39-1.03.39-1.42 0l-2.07-2.09c-.38-.39-.38-1.01 0-1.39l.01-.01c.39-.39 1.02-.39 1.4 0l1.37 1.37 4.43-4.46c.39-.39 1.02-.39 1.41 0l.01.01c.38.39.38 1.01 0 1.39l-5.14 5.18z" />
                                                        </svg></a></td>
                                                @endcan
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
            @if(!Auth::user()->hasRole('Vendor'))
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Shortlisted Candidate</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="panel panel-primary filterable">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-4 p-1">
                                            <form action="{{ route('common.shortlist_filter_by_exp') }}" method="post">
                                                @csrf
                                                <select class="form-control mr-1" style="width:50%;float:left" name="exp">
                                                    <option value=" ">Choose Experience</option>
                                                    <option value="1" @if('1' == $exp)
                                                    selected @endif>1</option>
                                                    <option value="2"@if('2' == $exp)
                                                    selected @endif>2</option>
                                                    <option value="3"@if('3' == $exp)
                                                    selected @endif>3</option>
                                                    <option value="4"@if('4' == $exp)
                                                    selected @endif>4</option>
                                                    <option value="5"@if('5' == $exp)
                                                    selected @endif>5</option>
                                                    <option value="6"@if('6' == $exp)
                                                    selected @endif>6</option>
                                                    <option value="7"@if('7' == $exp)
                                                    selected @endif>7</option>
                                                    <option value="8"@if('8' == $exp)
                                                    selected @endif>8</option>
                                                    <option value="9"@if('9' == $exp)
                                                    selected @endif>9</option>
                                                    <option value="10"@if('10' == $exp)
                                                    selected @endif>10</option>
                                                </select>
                                                <input type="hidden" name="jobid"value="{{$job->id}}">
                                                <button type="submit" class="btn btn-info mt-0">Filter By Experience</button>
                                            </form>
                                        </div>
                                        <div class="col-lg-4 p-1">
                                            <form action="{{ route('common.shortlist_filter_by_age') }}" method="post">
                                                @csrf
                                                <input type="number" name="age" value=" " min='0' style="width:150px" value="{{$age}}" placeholder="Enter Age here">
                                                <input type="hidden" name="jobid"value="{{$job->id}}">
                                                <button type="submit" class="btn btn-info mt-0">Filter By Age</button>
                                                <a href="{{route('common.jobs.show',$job->id)}}" style="padding: 0.425rem .5rem;" class=" mt-0 btn btn-success "><span class="material-icons">cached</span></a>
                                            </form>
                                        </div>
                                        <div class="col-lg-4">
                                            <h3 class="panel-title @if(!Auth::user()->hasRole('Vendor')) text-right @endif mb-0">
                                                <button class="btn btn-default btn-xs btn-filter mt-1"><span class="glyphicon glyphicon-filter"></span>Click To Apply Filter</button>
                                            </h3>
                                        </div>
                                    </div>
                                    @if($errors->has('job_id'))
                                                   <p class="text-danger">{{ $errors->first('job_id') }}</p>
                                                @endif
                                                @if(isset($applied_jobs['candidate_detail'][0]->name) && isset($applied_jobs['vendors_candidate_detail'][0]))

                                                @if($applied_jobs['candidate_detail'][0]->name == NULL && $applied_jobs['vendors_candidate_detail'][0] == NULL)
                                    <h6 class="text-danger">No Result Found</h6>
                                    @endif
                                    @endif
                                    </div>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="filters">
                                                <th style="width:10px;"><input type="text" class="form-control"
                                                        placeholder="#" disabled></th>
                                                <th><input type="text" class="form-control" placeholder="Candidate"
                                                        disabled></th>
                                                        <th><input type="text" class="form-control" placeholder="Email"
                                                        disabled></th>
                                                <th><input type="text" class="form-control" placeholder="Age" disabled>
                                                </th>
                                                <th><input type="text" class="form-control" placeholder="Education"
                                                        disabled></th>
                                                        <th><input type="text" class="form-control" placeholder="Experience"
                                                        disabled></th>

                                                <th><input type="text" class="form-control" placeholder="Applied By"
                                                        disabled></th>
                                                <th><input type="text" class="form-control" placeholder="Applied Date"
                                                        disabled></th>
                                                        @can('job_shortlist_access')
                                                <th><input type="text" class="form-control" placeholder="Action"
                                                        disabled></th>
                                                        @endcan
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($shortlist_candidates['candidate_detail'] as $key => $applied_job)
                                            @if($shortlist_candidates['candidate_detail'][$key]->id != NULL)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td><a class="" target="_blank"
                                                        href="{{ route('common.candidate.show', $shortlist_candidates['candidate_detail'][$key]->id) }}">{{ $shortlist_candidates['candidate_detail'][$key]->name }}</a>
                                                </td>
                                                <td>{{ $shortlist_candidates['candidate_detail'][$key]->email  }}</td>
                                                <td>{{ \Carbon\Carbon::parse($shortlist_candidates['profile'][$key]->dob)->age  }}
                                                </td>
                                                <td>@foreach(json_decode($shortlist_candidates['candidate_edu'][$key]['course'],
                                                    true) as $course){{ $course }}<br> @endforeach</td>

                                                    <td>@foreach(json_decode($shortlist_candidates['candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                    @php
                                                    $startTime = \Carbon\Carbon::parse($start_year);

                                                    $endTime = \Carbon\Carbon::parse(json_decode($shortlist_candidates['candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                    @endphp
                                                @endforeach

                                                {{round($totalDuration/12,1).' Year'}}

                                                </td>

                                                @if($shortlist_candidates['appliedcandidates'][$key]->applied_by ==
                                                NULL)
                                                <td>Candidate</td>
                                                @else
                                                <td><button type="button" class="btn btn-info btn-lg vendor_profile"
                                                        value="{{$shortlist_candidates['appliedcandidates'][$key]->applied_by}}"
                                                        data-toggle="modal" data-target="#myModal">Vendor</button></td>
                                                @endif
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $shortlist_candidates['appliedcandidates'][$key]->applied_date)->format('d-M-Y H:i:s') }}
                                                </td>
                                                @can('job_shortlist_access')
                                                <td><a class="btn btn-sm btn-success"
                                                        href="{{ route('common.unshortlist', $shortlist_candidates['appliedcandidates'][$key]->id) }}"><span class="material-icons">
clear
</span></a></td>
                                                @endcan
                                            </tr>
                                            @endif
                                            @endforeach
                                     @if(isset($shortlist_candidates['vendors_candidate_detail']) && isset($shortlist_candidates['vendors_candidate_detail'][0]) && $shortlist_candidates['vendors_candidate_detail'][0]->id != '')wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
                                                @if(!Auth::user()->hasRole('Vendor'))
                                             <tr><th colspan="9" class="text-center">Vendors Candidates</th></tr>
                                             @endif
                                            @endif
                                            @foreach($shortlist_candidates['vendors_candidate_detail'] as $key => $applied_job)
                                            @if($shortlist_candidates['vendors_candidate_detail'][$key]->id != NULL)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td><a class="" target="_blank"
                                                        href="{{ route('common.candidate.show', $shortlist_candidates['vendors_candidate_detail'][$key]->id) }}">{{ $shortlist_candidates['vendors_candidate_detail'][$key]->name }}</a>
                                                </td>
                                                <td>{{ $shortlist_candidates['vendors_candidate_detail'][$key]->email  }}</td>
                                                <td>{{ \Carbon\Carbon::parse($shortlist_candidates['vendors_candidate_detail'][$key]->dob)->age  }}
                                                </td>
                                                <td>@foreach(json_decode($shortlist_candidates['vendors_candidate_edu'][$key]['course'],
                                                    true) as $course){{ $course }}<br> @endforeach</td>

                                                    <td>@foreach(json_decode($shortlist_candidates['vendors_candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                    @php
                                                    $startTime = \Carbon\Carbon::parse($start_year);

                                                    $endTime = \Carbon\Carbon::parse(json_decode($shortlist_candidates['vendors_candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                    @endphp
                                                @endforeach

                                                {{round($totalDuration/12,1).' Year'}}

                                                </td>

                                                @if($shortlist_candidates['vendors_appliedcandidates'][$key]->applied_by ==
                                                NULL)
                                                <td>Candidate</td>
                                                @else
                                                <td><button type="button" class="btn btn-info btn-lg vendor_profile"
                                                        value="{{$shortlist_candidates['vendors_appliedcandidates'][$key]->applied_by}}"
                                                        data-toggle="modal" data-target="#myModal">Vendor</button></td>
                                                @endif
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $shortlist_candidates['vendors_appliedcandidates'][$key]->applied_date)->format('d-M-Y H:i:s') }}
                                                </td>
                                                @can('job_shortlist_access')
                                                <td><a class="btn btn-sm btn-success"
                                                        href="{{ route('common.unshortlist', $shortlist_candidates['vendors_appliedcandidates'][$key]->id) }}"><span class="material-icons">clear</span></a></td>
                                                @endcan
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Vendor Profile</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td id="VendorName"></td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td id="VendorEmail"></td>
                            </tr>
                            <tr>
                                <th scope="row">Phone</th>
                                <td id="VendorPhone"></td>
                            </tr>
                            <tr>
                                <th scope="row">Registration Number</th>
                                <td id="VendorRegNo"></td>
                            </tr>
                            <tr>
                                <th scope="row">City</th>
                                <td id="VendorCity"></td>
                            </tr>
                            <tr>
                                <th scope="row">State</th>
                                <td id="VendorState"></td>
                            </tr>
                            <tr>
                                <th scope="row">Zip Code</th>
                                <td id="VendorZip"></td>
                            </tr>
                            <tr>
                                <th scope="row">Country</th>
                                <td id="VendorCountry"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    @section('scripts')
    <script>
        $(document).ready(function () {
            $(".vendor_profile").click(function () {
                var vendor_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/common/get-vendor/" + vendor_id,
                    success: function (results) {
                        $('#VendorName').empty();
                        $('#VendorEmail').empty();
                        $('#VendorPhone').empty();
                        $('#VendorRegNo').empty();
                        $('#VendorServNo').empty();
                        $('#VendorCity').empty();
                        $('#VendorState').empty();
                        $('#VendorZip').empty();
                        $('#VendorCountry').empty();
                        var results = JSON.parse(results);
                        $('#VendorName').append(results.name);
                        $('#VendorEmail').append(results.email);
                        $('#VendorPhone').append(results.phone);
                        $('#VendorRegNo').append(results.vendor_reg_no);
                        $('#VendorServNo').append(results.vendor_service_id_no);
                        $('#VendorCity').append(results.city);
                        $('#VendorState').append(results.state);
                        $('#VendorZip').append(results.zip_code);
                        $('#VendorCountry').append(results.country);
                    }
                });
            });
        });

    </script>
    <script src="{{ asset('app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/project-bug-list.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/project-summary-bug.min.js') }}"></script>

    <!-- table js -->
    <script src="{{ asset('filter-each-column/Filter.js')}}"></script>
    <script>
        try {
            fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js",{
                method: 'HEAD',
                mode: 'no-cors'
            })).then(function (response) {
                return true;
            }).catch(function (e) {
                var carbonScript = document.createElement("script");
                carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
                carbonScript.id = "_carbonads_js";
                document.getElementById("carbon-block").appendChild(carbonScript);
            });
        } catch (error) {
            console.log(error);
        }

    </script>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <!-- end table js -->
    @endsection
    @endsection
