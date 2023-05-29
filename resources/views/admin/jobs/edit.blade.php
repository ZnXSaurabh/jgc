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
                    <h4 class="card-title">Edit Job</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-danger" href="{{ route('common.jobs.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <form action="{{ route('common.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6 {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <label for="title">{{ trans('global.job.fields.title') }} *</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($job) ? $job->title : '') }}">
                                    @if($errors->has('title'))
                                    <p class="help-block">{{ $errors->first('title') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('jobid') ? 'has-error' : '' }}">
                                    <label for="jobid">Job ID *</label>
                                    <input type="text" id="jobid" name="jobid" class="form-control" value="{{ old('jobid', isset($job) ? $job->jobid : '') }}">
                                    @if($errors->has('jobid'))
                                    <p class="help-block">{{ $errors->first('jobid') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('salary') ? 'has-error' : '' }}">
                                    <label for="salary">Salary</label>
                                    <input type="text" id="salary" name="salary" class="form-control" value="{{ old('salary', isset($job) ? $job->salary : '') }}">
                                    @if($errors->has('salary'))
                                    <p class="help-block">{{ $errors->first('salary') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('job_type') ? 'has-error' : '' }}">
                                    <label for="job_type">Job Type *</label>
                                    <select name="job_type" id="job_type" class="form-control select2">
                                        @foreach($job_types as $job_type)
                                        <option value="{{$job_type->id}}" {{ old('job_type_id', $job->job_type_id == $job_type->id) ? 'selected' : '' }}>{{$job_type->job_type}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('job_type'))
                                    <p class="help-block">{{ $errors->first('job_type') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('department') ? 'has-error' : '' }}">
                                    <label for="department">Department *</label>
                                    <select name="department" id="department" class="form-control select2">
                                        @foreach($departments as $department)
                                        <option value="{{$department->id}}" {{ old("department_id", $job->department_id == $department->id) ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('department'))
                                    <p class="help-block">{{ $errors->first('department') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('designation') ? 'has-error' : '' }}">
                                    <label for="designation">Designation *</label>
                                    <select name="designation" id="designation" class="form-control select2">
                                        @foreach($designations as $designation)
                                        <option value="{{$designation->id}}" {{ old('designation_id', $job->designation_id == $designation->id) ? 'selected' : '' }}>{{$designation->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('designation'))
                                    <p class="help-block">{{ $errors->first('designation') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('location_preference') ? 'has-error' : '' }}">
                                    <label for="location_preference">Location Preference *</label>
                                    <select name="location_preference" id="location_preference" class="form-control select2">
                                        <option>Choose Location Preference</option>
                                        <option value="All Nationality" @if($job->location_preference == "All Nationality") selected @endif>All Nationality</option>
                                        <option value="Expatriates Only"  @if($job->location_preference == "Expatriates Only") selected @endif>Expatriates Only</option>
                                        <option value="Saudi National Only"  @if($job->location_preference == "Saudi National Only") selected @endif>Saudi National Only</option>
                                        <option value="All GCC Nationalities"  @if($job->location_preference == "All GCC Nationalities") selected @endif>All GCC Nationalities</option>
                                    
                                    </select>
                                    @if($errors->has('location_preference'))
                                    <p class="help-block">{{ $errors->first('location_preference') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('gender_preference') ? 'has-error' : '' }}">
                                    <label for="gender_preference">Gender Preference *</label>
                                    <select name="gender_preference" id="gender_preference" class="form-control select2">
                                        @if($job->gender_preference == 'Male')
                                        <option value="Male" selected>Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Any" >Any</option>
                                        @elseif($job->gender_preference == 'Female')
                                        <option value="Male">Male</option>
                                        <option value="Female" selected>Female</option>
                                        <option value="Any" >Any</option>
                                        @elseif($job->gender_preference == 'Any')
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Any" selected>Any</option>
                                        @endif
                                    </select>
                                    @if($errors->has('gender_preference'))
                                    <p class="help-block">{{ $errors->first('gender_preference') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('no_of_vacancy') ? 'has-error' : '' }}">
                                    <label for="no_of_vacancy">No of Vacancy *</label>
                                    <input type="number" name="no_of_vacancy" value="{{$job->no_of_vacancy}}" id="no_of_vacancy" class="form-control">
                                    @if($errors->has('no_of_vacancy'))
                                    <p class="help-block">{{ $errors->first('no_of_vacancy') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('minimum_exp_req') ? 'has-error' : '' }}">
                                    <label for="minimum_exp_req">Minimum Experience Required in years </label>
                                    <input type="number" id="minimum_exp_req" value="{{$job->minimum_exp_req}}" name="minimum_exp_req" class="form-control" min="0" max="40">
                                    @if($errors->has('minimum_exp_req'))
                                    <p class="text-danger">{{ $errors->first('minimum_exp_req') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('minimum_qualification') ? 'has-error' : '' }}">
                                    <label for="minimum_qualification">Minimum Qualification *</label>
                                    <input type="text" id="minimum_qualification" name="minimum_qualification" class="form-control" value="{{ $job->minimum_qualification }}">
                                    @if($errors->has('minimum_qualification'))
                                    <p class="text-danger">{{ $errors->first('minimum_qualification') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('location_id') ? 'has-error' : '' }}">
                                    <label for="location_id">Location *</label>
                                    <select name="location_id" id="location_id" class="form-control select2">
                                        @foreach($locations as $location)
                                        <option value="{{$location->id}}" {{ old('location_id', $job->location_id == $location->id) ? 'selected' : '' }}>{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('location_id'))
                                    <p class="help-block">{{ $errors->first('location_id') }}</p>
                                    @endif
                                </div>
                                @if($job->approved_by != '')
                                <div class="form-group col-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label for="status">Choose Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        @if($job->status == '1')
                                        <option value="1" selected>Activate</option>
                                        <option value="0">Deactivate</option>
                                        @elseif($job->status == '0')
                                        <option value="0" selected>Deactivate</option>
                                        <option value="1">Activate</option>
                                        @endif
                                    </select>
                                    @if($errors->has('status'))
                                    <p class="help-block">{{ $errors->first('status') }}</p>
                                    @endif
                                </div>
                                @endif
                                <div class="form-group col-6 {{ $errors->has('job_expiry_date') ? 'has-error' : '' }}">
                                    <label>Job Expiry Date</label>
                                    <input type="text" placeholder="Choose Expiry Date" value="{{$job->job_expiry_date}}" class="form-control required job_expiry_date" id="datepicker" name="job_expiry_date">
                                    @if($errors->has('job_expiry_date'))
                                    <p class="help-block">{{ $errors->first('job_expiry_date') }}</p>
                                    @endif
                                </div>
                                <!-- <div class="form-group col-6 {{ $errors->has('attachment') ? 'has-error' : '' }}">
                                    <label>Attachment </label>
                                    <input type="file" name="attachment" class="form-control">
                                    @if($errors->has('attachment'))
                                    <p class="help-block">{{ $errors->first('attachment') }}</p>
                                    @endif
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="form-group col-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="description">{{ trans('global.job.fields.description') }} *</label>
                                    <textarea id="description" name="description" class="form-control ">{{ old('description', isset($job) ? $job->description : '') }}</textarea>
                                    @if($errors->has('description'))
                                    <p class="help-block">{{ $errors->first('description') }}</p>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit" >{{ trans('global.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- jquery datepicker -->

<script>
  $(document).ready(function(){
  $( function() {
    $("#datepicker" ).datepicker({  changeMonth: true, 
    changeYear: true, dateFormat: 'yy-mm-dd',minDate: 0 });
  } );
});
  </script>
<!-- End jquery datepicker -->
<script src="{{ asset('app-assets/js/scripts/pages/material-app.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
$('.select2').select2({
placeholder: 'Select an option'
});
CKEDITOR.replace('description');
</script>
@endsection