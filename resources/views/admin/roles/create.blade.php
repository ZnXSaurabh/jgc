@extends('layouts.admin') 
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
<style  nonce="{{ csp_nonce() }}">
.select2-container--default .select2-selection--multiple .select2-selection__rendered li{
    margin:10px;
}
</style>
@endsection
@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Role</h4>
                    <a class="heading-elements-toggle">
                        <i class="la la-ellipsis-v font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-danger" href="{{ route('superadmin.permissions.index') }}">
                                    <span class="material-icons">keyboard_backspace</span>
                                    Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <form action="{{ route("superadmin.roles.store") }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">{{trans('global.role.fields.title')}}*</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title', isset($role) ? $role->title : '') }}">
                                @if($errors->has('title'))
                                <p class="help-block">{{$errors->first('title')}}
                                </p>
                                @endif
                                <p class="helper-block">{{trans('global.role.fields.title_helper')}}
                                </p>
                            </div>
                            <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                                <label for="permissions">{{trans('global.role.fields.permissions')}}*</label>
                                <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple">
                                    @foreach($permissions as $id => $permissions)
                                    <option value="{{ $id }}"
                                        {{(in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : ''}}>
                                        {{$permissions}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('permissions'))
                                <p class="help-block">{{$errors->first('permissions')}}
                                </p>
                                @endif
                                <p class="helper-block">{{trans('global.role.fields.permissions_helper')}}
                                </p>
                            </div>
                            <div>
                                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('app-assets/js/scripts/pages/material-app.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
<script>
$('.select2').select2({
    placeholder: 'Select an option',
    width: '100%'
});
</script>
@endsection