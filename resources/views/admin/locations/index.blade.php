@extends('layouts.admin')
@section('content')
<div class="content-body">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">All Locations</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <div class="row">
              <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.locations.create') }}">Add Location</a>
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
            <table id="location_table" class="table table-striped table-bordered dom-jQuery-events">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Location</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($locations as $key => $location)
                <tr data-entry-id="{{ $location->id }}">
                  <td>{{$key+1}}</td>
                  <td>{{ $location->name ?? '' }}</td>
                  <td>
                    <a class="btn btn-xs btn-secondary" href="{{ route('admin.locations.edit', $location->id) }}">
                      <span class="material-icons">create</span>
                    </a>
                    <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <button type="submit" class="btn btn-xs btn-danger"><span class="material-icons">delete</span></button>
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
@endsection
@section('scripts')
@endsection