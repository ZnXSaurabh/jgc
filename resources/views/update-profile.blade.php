@extends('layouts.web')
@section('styles')
<style type="text/css">
.add_education,
.add_experience{
    font-size: 14px;
    margin-bottom: 20px;
    float: left;
}
.remove_area,
.remove_exp{
    font-size: 14px;
    margin-bottom: 20px;
    float: left;
}
.add_remvoe_btn{
    position: relative;
}
.content_file div{
    display: flex;
    margin-top: 10px;
}
.intl-tel-input{
    display: flex !important;
}
hr{
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    width: 100%;
}
label.danger, span.error-message.dob-error{
    color: red;
}
::-webkit-datetime-edit-year-field:not([aria-valuenow]),
::-webkit-datetime-edit-month-field:not([aria-valuenow]),
::-webkit-datetime-edit-day-field:not([aria-valuenow]) {
    color: transparent;
}
input[type=date]:required:invalid::-webkit-datetime-edit {
    color: transparent;
}
input[type=date]:focus::-webkit-datetime-edit {
    color: black !important;
}
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/material-vertical-menu-modern.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}"> -->
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/wizard.min.css') }}">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url(front/images/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Welcome {{ Auth::user()->name }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if (\Session::has('message'))
<div class="alert alert-info ">
        <li class="text-center text-success">{!! \Session::get('message') !!}</li>
</div>
@endif
<section class="app-content">
    <div class="block no-padding">
        <div class="container">
            <div class="row no-gape">
                <div class="col-lg-12 column">
                    <div class="container">
                        <span class="success" style="display: none;"></span>
                        <section id="validation">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form id="candidate-update" class="steps-validation wizard-circle" enctype="multipart/form-data">
                                        @method('PUT')
                                        <h6>Personal Details</h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Full Name <span class="danger">*(Candidate Name should be same as per Passport)</span> </label>
                                                        <input value="{{ $candidate->name }}" type="text" class="form-control required" id="name" name="name">
                                                        <span class="error-message name-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email <span class="danger">*</span></label>
                                                        <input value="{{ $candidate->email }}" type="email" class="form-control required" id="email" name="email">
                                                        <span class="error-message email-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Phone Number <span class="danger">*</span></label>
                                                        <input value="{{ $candidate->phone }}" type="tel" minlength="10" maxlength="20" class="form-control required" id="phone" name="phone">
                                                        <span class="error-message phone-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="gender">Gender <span class="danger">*</span></label>
                                                        <select class="select2 form-control required" id="gender" name="gender">
                                                            @if($candidate->profile->gender === null ?? empty($candidate->profile->gender))
                                                            <option></option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Transgender">Transgender</option>
                                                            @elseif($candidate->profile->gender === "Male")
                                                            <option value="Male" selected>Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Transgender">Transgender</option>
                                                            @elseif($candidate->profile->gender === "Female")
                                                            <option value="Male">Male</option>
                                                            <option value="Female" selected>Female</option>
                                                            <option value="Transgender">Transgender</option>
                                                            @elseif($candidate->profile->gender === "Transgender")
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Transgender" selected>Transgender</option>
                                                            @endif
                                                        </select>
                                                        <span class="error-message gender-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dob">Date Of Birth <span class="danger">*</span></label>
                                                        <input value="{{ $candidate->profile->dob }}" placeholder="Choose Date Of Birth" type="text" class="form-control required" id="datepicker" name="dob" >
                                                        <span class="error-message dob-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city">City </label>
                                                        <input value="{{ $candidate->profile->city }}" type="text" class="form-control required" id="city" name="city">
                                                        <span class="error-message city-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="state">State </label>
                                                        <input value="{{ $candidate->profile->state }}" type="text" class="form-control required" id="state" name="state">
                                                        <span class="error-message state-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="country">Country </label>
                                                        <select name="country" id="country" class="form-control required select2">
                                                            <option></option>
                                                            @foreach($countries as $country)
                                                            <option value="{{$country->name}}" {{ old('country', $candidate->profile->country == $country->name) ? 'selected' : '' }}>{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="error-message country-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pincode">Pin Code <span class="danger">*</span></label>
                                                        <input value="{{ $candidate->profile->zip_code }}" type="text" class="form-control" id="pincode" name="pincode">
                                                        <span class="error-message pincode-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="address">Address <span class="danger">*</span></label>
                                                        <input value="{{ $candidate->profile->address }}" type="text" class="form-control" id="address" name="address">
                                                        <span class="error-message address-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <!-- Step 2 -->
                                        <h6>Education Details</h6>
                                        <fieldset class="input_education">
                                        @php $levels = json_decode($educations->level, true); @endphp
                                        @if($levels !== null)
                                        @foreach($levels as $key => $level)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="level">Education Level <span class="danger">*</span></label>
                                                        <select name="level[]" class="form-control select2 required">
                                                            <option>Choose Level</option>
                                                            @foreach($EducationalLevels as $EducationalLevel)
                                                   <option value="{{$EducationalLevel->name}}" @if($EducationalLevel->name == $level) selected @endif>{{$EducationalLevel->name}}</option>
                                                   @endforeach
                                                        </select>
                                                        <span class="error-message level-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="course">Course <span class="danger">*</span></label>
                                                        @php $course = json_decode($educations->course, true); @endphp
                                                        <input value="{{ $course[$key] ?? '' }}" type="text" class="form-control required" id="course" name="course[]">
                                                        <span class="error-message course-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="education_start_year">Start Year <span class="danger">*</span></label>
                                                        @php $start_year = json_decode($educations->start_year, true); @endphp
                                                        <input value="{{ $start_year[$key] ?? '' }}" type="text" name="education_start_year[]"  class="edustartdatepicker form-control required">
                                                        <span class="error-message education_start_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="education_end_year">End Year <span class="danger">*</span></label>
                                                        @php $end_year = json_decode($educations->end_year, true); @endphp
                                                        <input value="{{ $end_year[$key] ?? '' }}" type="text" name="education_end_year[]"  class="eduenddatepicker form-control required">
                                                        <span class="error-message education_end_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="university">University <span class="danger">*</span></label>
                                                        @php $university = json_decode($educations->university, true); @endphp
                                                        <input value="{{ $university[$key] ?? '' }}" type="text" class="form-control required" id="university" name="university[]">
                                                        <span class="error-message university-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="percentage">Percentage <span class="danger">*</span></label>
                                                        @php $percentage = json_decode($educations->percentage, true); @endphp
                                                        <input value="{{ $percentage[$key] ?? '' }}" type="number" min="30" max="100" class="form-control required" id="percentage" name="percentage[]">
                                                        <span class="error-message percentage-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 add_remvoe_btn">
                                                    <button class="btn btn-danger remove_area">Remove Education</button>
                                                </div>
                                                <hr>
                                            </div>
                                            @endforeach
                                            <div class="row">
                                                <div class="col-12 add_remvoe_btn">
                                                    <button class="btn btn-info add_education">Add Education</button>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="level">Education Level <span class="danger">*</span></label>
                                                        <select name="level[]" class="form-control select2 required">
                                                            <option>Choose Level</option>
                                                            @foreach($EducationalLevels as $EducationalLevel)
                                                   <option value="{{$EducationalLevel->name}}" @if($EducationalLevel->name == $level) selected @endif>{{$EducationalLevel->name}}</option>
                                                   @endforeach
                                                        </select>
                                                        <span class="error-message level-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="course">Course <span class="danger">*</span></label>
                                                        <input type="text" class="form-control required" id="course" name="course[]">
                                                        <span class="error-message course-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="education_start_year">Start Year <span class="danger">*</span></label>
                                                        <input type="text" name="education_start_year[]"  class="edustartdatepicker form-control required">
                                                        <span class="error-message education_start_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="education_end_year">End Year <span class="danger">*</span></label>
                                                        <input type="text" name="education_end_year[]"  class="eduenddatepicker form-control required">
                                                        <span class="error-message education_end_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="university">University <span class="danger">*</span></label>
                                                        <input type="text" class="form-control required" id="university" name="university[]">
                                                        <span class="error-message university-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="percentage">Percentage <span class="danger">*</span></label>
                                                        <input type="number" min="30" max="100" class="form-control required" id="percentage" name="percentage[]">
                                                        <span class="error-message percentage-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 add_remvoe_btn">
                                                    <button class="btn btn-info add_education">Add Education</button>
                                                </div>
                                            </div>
                                            @endif
                                        </fieldset>
                                        <!-- Step 3 -->
                                        <h6>Work Experience</h6>
                                        <fieldset class="input_experience">
                                            @php $levels = json_decode($experiences->level, true); @endphp
                                            @if($levels !== null)
                                            @foreach($levels as $key => $level)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="experiencelevel">Experience Level <span class="danger">*</span></label>
                                                        <select class="form-control" id="experiencelevel" name="experiencelevel[]">
                                                            <option>Choose Level</option>
                                                            @if($level == 'Fresher')
                                                            <option value="Fresher" selected>Fresher</option>
                                                            <option value="Experienced">Experienced</option>
                                                            @elseif($level == 'Experienced')
                                                            <option value="Fresher">Fresher</option>
                                                            <option value="Experienced" selected>Experienced</option>
                                                            @endif
                                                        </select>
                                                        <span class="error-message experiencelevel-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="designation">Designation</label>
                                                        @php $designation = json_decode($experiences->designation, true); @endphp
                                                        <input value="{{ $designation[$key] ?? '' }}" type="text" class="form-control" id="designation" name="designation[]">
                                                        <span class="error-message designation-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="department">Department</label>
                                                        @php $department = json_decode($experiences->department, true); @endphp
                                                        <input value="{{ $department[$key] ?? '' }}" type="text" class="form-control" id="department" name="department[]">
                                                        <span class="error-message department-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="organisation">Organisation</label>
                                                        @php $organisation = json_decode($experiences->organisation, true); @endphp
                                                        <input value="{{ $organisation[$key] ?? '' }}" type="text" class="form-control" id="organisation" name="organisation[]">
                                                        <span class="error-message organisation-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="experience_start_year">Start Year</label>
                                                        @php $start_year = json_decode($experiences->start_year, true); @endphp
                                                        <input value="{{ $start_year[$key] ?? '' }}" type="text" name="experience_start_year[]" class="expstartdatepicker form-control" >
                                                        <span class="error-message experience_start_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="experience_end_year">End Year</label>
                                                        @php $end_year = json_decode($experiences->end_year, true); @endphp
                                                        <input value="{{ $end_year[$key] ?? '' }}" type="text" name="experience_end_year[]" class="expenddatepicker form-control" >
                                                        <span class="error-message experience_end_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 add_remvoe_btn">
                                                    <button class="btn btn-danger remove_exp">Remove Experiences</button>
                                                </div>
                                                <hr>
                                            </div>
                                            @endforeach
                                            <div class="row">
                                                <div class="col-12 add_remvoe_btn">
                                                    <button class="btn btn-info add_experience">Add Experience</button>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="experiencelevel">Experience Level <span class="danger">*</span></label>
                                                        <select class="form-control select2" id="experiencelevel" name="experiencelevel[]">
                                                            <option>Choose Level</option>
                                                            <option value="Fresher">Fresher</option>
                                                            <option value="Experienced">Experienced</option>
                                                        </select>
                                                        <span class="error-message experiencelevel-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="designation">Designation</label>
                                                        <input type="text" class="form-control" id="designation" name="designation[]">
                                                        <span class="error-message designation-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="department">Department</label>
                                                        <input type="text" class="form-control" id="department" name="department[]">
                                                        <span class="error-message department-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="organisation">Organisation</label>
                                                        <input type="text" class="form-control" id="organisation" name="organisation[]">
                                                        <span class="error-message organisation-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="experience_start_year">Start Year</label>
                                                        <input type="text" name="experience_start_year[]" class="expstartdatepicker form-control" >
                                                        <span class="error-message experience_start_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="experience_end_year">End Year</label>
                                                        <input type="text" name="experience_end_year[]" class="expenddatepicker form-control" >
                                                        <span class="error-message experience_end_year-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 add_remvoe_btn">
                                                    <button class="btn btn-info add_experience">Add Experience</button>
                                                </div>
                                            </div>
                                            @endif
                                        </fieldset>
                                        <!-- Step 4 -->
                                        <h6>Upload Document</h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="resume">Resume <span class="danger">*</span> {{ $candidate->profile->resume }}</label>
                                                        <input value="{{ $candidate->profile->resume }}" type="file" class="form-control" id="resume" name="resume" accept=".docx,.doc,.pdf" @if($candidate->profile->resume == NULL) required @endif>
                                                        <span class="error-message resume-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="profile_pic">Profile Picture {{ $candidate->profile->profile_pic }}</label>
                                                        <input value="{{ $candidate->profile->profile_pic }}" type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                                                        <span class="error-message profile_pic-error" style="display: none;"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="about">About </label>
                                                    <textarea id="about" name="about" class="form-control">{{ $candidate->profile->about }}</textarea>
                                                    <span class="error-message about-error" style="display: none;"></span>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                    <div id="validation-errors"></div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('app-assets/vendors/js/extensions/jquery.steps.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/wizard-steps.min.js') }}"></script>
<!-- <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script> -->
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
   // $('.select2').select2({
   //      placeholder: 'Select an option',
   //      width: '100%'
   //  });
    $(document.body).on('change', 'select#experiencelevel', function() {
        var val = $('#experiencelevel').val();
        if(val == "Fresher"){
            $('#designation').removeClass('required').siblings("label").children().remove();
            $('#department').removeClass('required').siblings("label").children().remove();
            $('#organisation').removeClass('required').siblings("label").children().remove();
            $('.expstartdatepicker').removeClass('required').siblings("label").children().remove();
            $('.expenddatepicker').removeClass('required').siblings("label").children().remove();
        }else if(val == "Experienced") {
            $('#designation').addClass('required').siblings("label").append(" <span class='danger'>*</span>");
            $('#department').addClass('required').siblings("label").append(" <span class='danger'>*</span>");
            $('#organisation').addClass('required').siblings("label").append(" <span class='danger'>*</span>");
            $('.expstartdatepicker').addClass('required').siblings("label").append(" <span class='danger'>*</span>");
            $('.expenddatepicker').addClass('required').siblings("label").append(" <span class='danger'>*</span>");
        }
    });
var max_fields      = 10;
var wrapper         = $(".input_education");
var add_button      = $(".add_education");
var x = 1;
$(add_button).click(function(e){
e.preventDefault();
if(x < max_fields){ x++;
$(wrapper).append(
    '<div class="row"><hr>'+
        '<div class="col-md-6">'+
            '<div class="form-group">'+
                '<label for="level">Education Level <span class="danger">*</span></label>'+
                '<select name="level[]" class="form-control select2 required">'+
                '<option>Choose Level</option>'+
                '@foreach($EducationalLevels as $EducationalLevel)'+
                '<option value="{{$EducationalLevel->name}}" @if($EducationalLevel->name == $level) selected @endif>{{$EducationalLevel->name}}</option>'+
                '@endforeach'+
                '</select>'+
                '<span class="error-message level-error" style="display: none;"></span>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
            '<div class="form-group">'+
                '<label for="course">Course <span class="danger">*</span></label>'+
                '<input type="text" class="form-control required" id="course" name="course[]">'+
                '<span class="error-message course-error" style="display: none;"></span>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
            '<div class="form-group">'+
                '<label for="education_start_year">Start Year <span class="danger">*</span></label>'+
                '<input type="text" name="education_start_year[]"  class="edustartdatepicker form-control required">'+
                '<span class="error-message education_start_year-error" style="display: none;"></span>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
           ' <div class="form-group">'+
                '<label for="education_end_year">End Year <span class="danger">*</span></label>'+
                '<input type="text" name="education_end_year[]"  class="eduenddatepicker form-control required">'+
                '<span class="error-message education_end_year-error" style="display: none;"></span>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
            '<div class="form-group">'+
                '<label for="university">University <span class="danger">*</span></label>'+
                '<input type="text" class="form-control required" id="university" name="university[]">'+
                '<span class="error-message university-error" style="display: none;"></span>'+
            '</div>'+
       ' </div>'+
        '<div class="col-md-6">'+
            '<div class="form-group">'+
                '<label for="percentage">Percentage <span class="danger">*</span></label>'+
                '<input type="number" min="30" max="100" class="form-control required" id="percentage" name="percentage[]">'+
                '<span class="error-message percentage-error" style="display: none;"></span>'+
            '</div>'+
        '</div>'+
        '<div class="col-12 add_remvoe_btn">'+
            '<button class="btn btn-danger remove_area">Remove Education</button>'+
        '</div>'+
    '</div>');
    }
    });
    $(wrapper).on("click",".remove_area", function(e){
        e.preventDefault(); $(this).parent().parent().remove(); x--;
    });

    var exp_wrapper         =   $(".input_experience");
    var add_exp_button      =   $(".add_experience");
    var x = 1;
    $(add_exp_button).click(function(e){
    e.preventDefault();
    if(x < max_fields){ x++;
    $(exp_wrapper).append(
        '<div class="row"><hr>'+
            '<div class="col-md-6">'+
                '<div class="form-group">'+
                    '<label for="experiencelevel">Experience Level <span class="danger">*</span></label>'+
                    '<select class="form-control select2" id="experiencelevel" name="experiencelevel[]">'+
                        '<option>Choose Level</option>'+
                        '<option value="Fresher">Fresher</option>'+
                        '<option value="Experienced">Experienced</option>'+
                    '</select>'+
                    '<span class="error-message experiencelevel-error" style="display: none;"></span>'+
                '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
                '<div class="form-group">'+
                    '<label for="designation">Designation</label>'+
                    '<input type="text" class="form-control" id="designation" name="designation[]">'+
                    '<span class="error-message designation-error" style="display: none;"></span>'+
                '</div>'+
           '</div>'+
            '<div class="col-md-6">'+
               ' <div class="form-group">'+
                    '<label for="department">Department</label>'+
                    '<input type="text" class="form-control" id="department" name="department[]">'+
                    '<span class="error-message department-error" style="display: none;"></span>'+
                '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
                '<div class="form-group">'+
                    '<label for="organisation">Organisation</label>'+
                    '<input type="text" class="form-control" id="organisation" name="organisation[]">'+
                    '<span class="error-message organisation-error" style="display: none;"></span>'+
                '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
               ' <div class="form-group">'+
                    '<label for="experience_start_year">Start Year</label>'+
                   ' <input type="text" name="experience_start_year[]" class="expstartdatepicker form-control" >'+
                   ' <span class="error-message experience_start_year-error" style="display: none;"></span>'+
                '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
               ' <div class="form-group">'+
                    '<label for="experience_end_year">End Year</label>'+
                   ' <input type="text" name="experience_end_year[]" class="expenddatepicker form-control" >'+
                    '<span class="error-message experience_end_year-error" style="display: none;"></span>'+
                '</div>'+
            '</div>'+
            '<div class="col-12 add_remvoe_btn">'+
                '<button class="btn btn-danger remove_exp">Remove Experiences</button>'+
            '</div>'+
        '</div>');
        }
    });
    $(exp_wrapper).on("click",".remove_exp", function(e){
        e.preventDefault(); $(this).parent().parent().remove(); x--;
    });
    CKEDITOR.replace('about');

    $('.wizard .actions').find('a[href="#finish"]').remove();
    $('.wizard .actions li:last-child').append('<button type="submit" id="submit" class="btn btn-success">Update</button>');
    $("a[role='menuitem']").click( function(){
        if($('.steps ul .last').hasClass('current')){
            $('.wizard .actions li:last-child').css("display","block");
        }else{
            $('.wizard .actions li:last-child').css("display","none");
        }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });
    $('#candidate-update').submit( function(event) {
        event.preventDefault();
        for ( instance in CKEDITOR.instances ) {
        CKEDITOR.instances[instance].updateElement();
    }
        $.ajax({
            type: 'POST',
            url: "{{ route('common.candidate.update',$candidate->id) }}",
            data: new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData:false,
            success: function(response) {
                 $('#submit').prop('disabled',true).text('Submit');
                alert("Your profile updated successfully!");
                // .delay(3500).fadeOut('slow');
                // $('#candidate-update').trigger("reset");
                window.location.href = "{{ route('browse-jobs') }}";
            },
            error: function(response) {
                $('.error-message').css('display', 'none');
                if(response) {
                    console.log(response.responseJSON.errors);
                    $('#validation-errors').html('');
                    $.each(response.responseJSON.errors, function(key,value) {
                        $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
                    }); 
                    if(response.responseJSON.errors.name) {
                        $('.fullname-error').css('display', 'block').html(response.responseJSON.errors.name);
                        $('.fullname-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.email) {
                        $('.email-error').css('display', 'block').html(response.responseJSON.errors.email);
                        $('.email-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.phone) {
                        $('.phone-error').css('display', 'block').html(response.responseJSON.errors.phone);
                        $('.phone-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.gender) {
                        $('.gender-error').css('display', 'block').html(response.responseJSON.errors.gender);
                        $('.gender-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.dob) {
                        $('.dob-error').css('display', 'block').html(response.responseJSON.errors.dob);
                        $('.dob-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.city) {
                        $('.city-error').css('display', 'block').html(response.responseJSON.errors.city);
                        $('.city-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.state) {
                        $('.state-error').css('display', 'block').html(response.responseJSON.errors.state);
                        $('.state-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.country) {
                        $('.country-error').css('display', 'block').html(response.responseJSON.errors.country);
                        $('.country-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.pincode) {
                        $('.pincode-error').css('display', 'block').html(response.responseJSON.errors.pincode);
                        $('.pincode-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.address) {
                        $('.address-error').css('display', 'block').html(response.responseJSON.errors.address);
                        $('.address-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.level) {
                        $('.level-error').css('display', 'block').html(response.responseJSON.errors.level);
                        $('.level-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.course) {
                        $('.course-error').css('display', 'block').html(response.responseJSON.errors.course);
                        $('.course-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.university) {
                        $('.university-error').css('display', 'block').html(response.responseJSON.errors.university);
                        $('.university-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.percentage) {
                        $('.percentage-error').css('display', 'block').html(response.responseJSON.errors.percentage);
                        $('.percentage-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.education_start_year) {
                        $('.education_start_year-error').css('display', 'block').html(response.responseJSON.errors.education_start_year);
                        $('.education_start_year-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.education_end_year) {
                        $('.education_end_year-error').css('display', 'block').html(response.responseJSON.errors.education_end_year);
                        $('.education_end_year-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.experiencelevel) {
                        $('.experiencelevel-error').css('display', 'block').html(response.responseJSON.errors.experiencelevel);
                        $('.experiencelevel-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.designation) {
                        $('.designation-error').css('display', 'block').html(response.responseJSON.errors.designation);
                        $('.designation-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.department) {
                        $('.department-error').css('display', 'block').html(response.responseJSON.errors.department);
                        $('.department-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.organisation) {
                        $('.organisation-error').css('display', 'block').html(response.responseJSON.errors.organisation);
                        $('.organisation-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.experience_start_year) {
                        $('.experience_start_year-error').css('display', 'block').html(response.responseJSON.errors.experience_start_year);
                        $('.experience_start_year-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.experience_end_year) {
                        $('.experience_end_year-error').css('display', 'block').html(response.responseJSON.errors.experience_end_year);
                        $('.experience_end_year-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.resume) {
                        $('.resume-error').css('display', 'block').html(response.responseJSON.errors.resume);
                        $('.resume-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.profile_pic) {
                        $('.profile_pic-error').css('display', 'block').html(response.responseJSON.errors.profile_pic);
                        $('.profile_pic-error').siblings("input").addClass("error-line");
                    }
                    if(response.responseJSON.errors.about) {
                        $('.about-error').css('display', 'block').html(response.responseJSON.errors.about);
                        $('.about-error').siblings("input").addClass("error-line");
                    }
                }
            }
        });
    });
});
</script>
<!-- jquery datepicker -->

<script>
  $(document).ready(function(){

  $( function() {
    $("#datepicker" ).datepicker({ changeMonth: true, 
    changeYear: true,  dateFormat: 'yy-mm-dd' });
  });
    $('html').on('focus',".edustartdatepicker", function(){
        $('.edustartdatepicker').datepicker({
            changeMonth: true, 
    changeYear: true, 
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
                $(".eduenddatepicker").datepicker("option","minDate", selected)
            }
        });
    });

    $('html').on('focus',".eduenddatepicker", function(){
        $('.eduenddatepicker').datepicker({
            changeMonth: true, 
    changeYear: true, 
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
                $(".edustartdatepicker").datepicker("option","maxDate", selected)
            }
        });
    });
    
    $('html').on('focus',".expstartdatepicker", function(){
        $('.expstartdatepicker').datepicker({
            changeMonth: true, 
    changeYear: true, 
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
            $(".expenddatepicker").datepicker("option","minDate", selected)
            }
        });
    });
    $('html').on('focus',".expenddatepicker", function(){
        $('.expenddatepicker').datepicker({
            changeMonth: true, 
    changeYear: true, 
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
            $(".expstartdatepicker").datepicker("option","maxDate", selected)
            }
        });
    });

});


  </script>
<!-- End jquery datepicker -->
@endsection