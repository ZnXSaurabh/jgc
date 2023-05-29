@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
@endsection
@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Educational Level</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-danger" href="{{ route('admin.educational_level.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <form action="{{ route('admin.educational_level.update',$EducationalLevel->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">{{ trans('global.job.fields.title') }}*</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($EducationalLevel) ? $EducationalLevel->name : '') }}">
                                @if($errors->has('title'))
                                <p class="help-block">
                                    {{ $errors->first('title') }}
                                </p>
                                @endif
                                <p class="helper-block">
                                    {{ trans('global.job.fields.title_helper') }}
                                </p>
                            </div>
                            <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                <label for="status">Choose Status</label>
                                <select name="status" class="form-control select2" required>
                                    @if($EducationalLevel->status == '1')
                                    <option value="1" selected>Activate</option>
                                    <option value="0">Deactivate</option>
                                    @elseif($EducationalLevel->status == '0')
                                    <option value="0" selected>Deactivate</option>
                                    <option value="1">Activate</option>
                                    @endif
                                </select>
                                @if($errors->has('status'))
                                <p class="help-block">{{ $errors->first('status') }}</p>
                                @endif
                            </div>
                            <div>
                                <button class="btn btn-success" type="submit" >{{ trans('global.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="{{ asset('app-assets/js/scripts/pages/material-app.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
<script>
$('.select2').select2({
placeholder: 'Select an option'
});
</script>
@endsection
@endsection