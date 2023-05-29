@extends('layouts.admin')
@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Job Type</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-danger" href="{{ route('admin.job_type.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <form action="{{route('admin.job_type.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group {{ $errors->has('job_type') ? 'has-error' : '' }}">
                                <label for="job_type">Job Type*</label>
                                <input type="text" id="job_type" name="job_type" class="form-control" >
                                @if($errors->has('job_type'))
                                <p class="help-block">{{ $errors->first('job_type') }}</p>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">{{ trans('global.job.fields.description') }}</label>
                                <textarea id="description" name="description" class="form-control ">{{ old('description', isset($job) ? $job->description : '') }}</textarea>
                                @if($errors->has('description'))
                                <p class="help-block">{{ $errors->first('description') }}</p>
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
@endsection