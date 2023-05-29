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
                    <h4 class="card-title">All Permission</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-success" href="{{ route('superadmin.permissions.create') }}">Add Permission</a>
                            </div>
                        </div>
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
                        <table id="permission_table" class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
                                    <th>{{ trans('global.permission.fields.title') }}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $key => $permission)
                                <tr data-entry-id="{{ $permission->id }}">
                                    <td>
                                        {{ $permission->title ?? '' }}
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-secondary" href="{{ route('superadmin.permissions.edit', $permission->id) }}"><span class="material-icons">create</span></a>
                                        <form action="{{ route('superadmin.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger" ><span class="material-icons">delete</span></button>
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