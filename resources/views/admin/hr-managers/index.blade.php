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
                    <h4 class="card-title">All HR Managers</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-success" href="{{ route('admin.hr_manager.create') }}">Add HR Manager</a>
                            </div>
                        </div>
                    </div>
                </div>
                @if(session('message'))
                <div class="alert alert-icon-right alert-info alert-dismissible mb-2" role="alert">
                    <span class="alert-icon">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
                    </span>
                    <strong>{!! session('message') !!}</strong>
                </div>
                @endif
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <table id="hr_manager_table" class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hr_managers as $hr_manager)
                                <tr data-entry-id="{{ $hr_manager->id }}">
                                    <td>{{ $hr_manager->name ?? '' }}</td>
                                    <td>{{ $hr_manager->email ?? '' }}</td>
                                    <td>@if($hr_manager->status=='1') Active @else Deactivated @endif</td>
                                    <td>
                                        <a class="btn btn-xs btn-info" href="{{route('admin.hr_manager.show',$hr_manager->id)}}"><span class="material-icons">visibility</span></a>
                                        <a class="btn btn-xs btn-secondary" href="{{ route('admin.hr_manager.edit',$hr_manager->id) }}"><span class="material-icons">create</span></a>
                                        <form action="{{route('admin.hr_manager.destroy',$hr_manager->id)}}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger" > <span class="material-icons">delete</span> </button>
                                        </form>
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