@extends('layouts.admin')
@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Department</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-danger" href="{{ route('admin.department.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <form action="{{route('admin.department.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">Title*</label>
                                <input type="text" id="title" name="title" class="form-control" >
                                @if($errors->has('title'))
                                <p class="help-block">
                                    {{ $errors->first('title') }}
                                </p>
                                @endif
                                <p class="helper-block">
                                    {{ trans('global.job.fields.title_helper') }}
                                </p>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">{{ trans('global.job.fields.description') }}</label>
                                <textarea id="description" name="description" class="form-control ">{{ old('description', isset($job) ? $job->description : '') }}</textarea>
                                @if($errors->has('description'))
                                <p class="help-block">
                                    {{ $errors->first('description') }}
                                </p>
                                @endif
                                <p class="helper-block">
                                    {{ trans('global.job.fields.description_helper') }}
                                </p>
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