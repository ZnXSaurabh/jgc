@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @if(Route::current()->uri == "common/jobs")
                    <h4 class="card-title">All Jobs</h4>
                    @elseif(Route::current()->uri == "common/approved_jobs")
                    <h4 class="card-title">Approved Jobs</h4>
                    @elseif(Route::current()->uri == "common/unapproved_jobs")
                    <h4 class="card-title">Unapproved Jobs</h4>
                    @elseif(Route::current()->uri == "common.show_expired_job")
                    <h4 class="card-title">Expired Jobs</h4>
                    @endif
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        @can('job_create')
                        <div class="row">
                            <div class="col-lg-12">
                            @if (\Request::is('common/unapproved_jobs') || \Request::is('common/approved_jobs'))
                            @else 
                                <a class="btn btn-success" href="{{ route('common.jobs.create') }}">{{ trans('global.add') }} {{ trans('global.job.title_singular') }}</a>
                                <a  class="btn btn-info" href="{{route('common.show_expired_job')}}">Show Expired Job</a>
                                <a href="{{route('common.jobs.index')}}" class="  btn btn-success "><span class="material-icons">cached</span></a>
                            @endif
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
                @if (session('message'))
                <div class="alert alert-icon-right alert-info alert-dismissible mb-2" role="alert">
                    <span class="alert-icon">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
                    </span>
                    <strong>{!! session('message') !!}</strong>
                </div>
                @endif
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <table id="jobs-index-table" class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Job ID</th>
                                    <th>{{ trans('global.job.fields.title') }}</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $key => $job)
                                <tr data-entry-id="{{ $job->id }}">
                                    <td>{{$key+1}}</td>
                                    <td>{{ $job->jobid ?? '' }}</td>
                                    <td>{{ $job->title ?? '' }}</td>
                                    <td>{{ App\Models\Location::where('id', $job->location_id)->pluck('name')->first() }}</td>
                                    @if(Route::current()->uri == "common/show_expired_job")
                                    <td> Inactive</td>
                                    @else
                                    <td> Active </td>
                                    @endif
                                  
                                    <td class="col-6">
                                        @can('job_edit')
                                        @if(Route::current()->uri == "common/jobs")
                                        <a class="btn btn-secondary" href="{{ route('common.jobs.edit', $job->id) }}"><span class="material-icons">create</span></a>
                                        @endif
                                        @endcan
                                        @can('job_show')
                                        <a class="btn btn-success" href="{{ route('common.jobs.show', $job->id) }}"><span class="material-icons">visibility</span></a>
                                        @endcan
                                        @can('job_delete')
                                        <form action="{{route('common.jobs.destroy',$job->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-danger"><span class="material-icons">delete</span></button>
                                        </form>
                                        @endcan
                                    </td>
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
@section('scripts')
<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
<!--     <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/jszip.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/pdfmake.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/vfs_fonts.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/buttons.print.min.js') }}"></script> -->
<script src="{{ asset('app-assets/js/scripts/pages/material-app.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/tables/datatables/datatable-advanced.min.js') }}"></script>
@endsection
@endsection