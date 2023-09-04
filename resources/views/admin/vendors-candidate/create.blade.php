@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/wizard.min.css') }}">
<style type="text/css"  nonce="{{ csp_nonce() }}">
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
hr{
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    width: 100%;
}
.app-content .wizard>.actions>ul>li>a {
    color: #fff !important;
    padding: 10px 12px !important;
    border: 1px solid transparent !important;
}
</style>
@endsection
@section('content')
<div class="content-body">
    <section id="validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Candidate</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a class="btn btn-danger" href="{{ route('common.candidate.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form id="candidate-registration" class="steps-validation wizard-circle" enctype="multipart/form-data">
                                <h6>Personal Details</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Full Name <span class="danger">*(Candidate Name should be same as per Passport)</span></label>
                                                <input type="text" class="form-control required" id="name" name="name">
                                                <span class="error-message name-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email <span class="danger">*</span></label>
                                                <input type="email" class="form-control required" id="email" name="email">
                                                <span class="error-message email-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Phone Number <span class="danger">*</span></label>
                                                <input type="tel" minlength="10" maxlength="13" class="form-control required" id="phone" name="phone">
                                                <span class="error-message phone-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">Gender <span class="danger">*</span></label>
                                                <select class="select2 form-control required" id="gender" name="gender">
                                                    <option></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="All">All</option>
                                                </select>
                                                <span class="error-message gender-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dob">Date Of Birth <span class="danger">*</span></label>
                                                <input type="text" placeholder="Choose Date Of Birth" class="form-control required" id="datepicker" name="dob" >
                                                <span class="error-message dob-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="city">City </label>
                                                <input type="text" class="form-control required" id="city" name="city">
                                                <span class="error-message city-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="state">State </label>
                                                <input type="text" class="form-control required" id="state" name="state">
                                                <span class="error-message state-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Country </label>
                                                <select name="country" id="country" class="form-control required select2">
                                                    <option></option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->name}}">{{$country->name}}</option>
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
                                                <input type="text" class="form-control required" id="pincode" name="pincode">
                                                <span class="error-message pincode-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address <span class="danger">*</span></label>
                                                <input type="text" class="form-control required" id="address" name="address">
                                                <span class="error-message address-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- Step 2 -->
                                <h6>Education Details</h6>
                                <fieldset class="input_education">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="level">Education Level <span class="danger">*</span></label>
                                                <select name="level[]" class="form-control select2 required">
                                                    <option></option>
                                                   @foreach($EducationalLevels as $EducationalLevel)
                                                   <option value="{{$EducationalLevel->name}}">{{$EducationalLevel->name}}</option>
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
                                                <input type="text" name="education_start_year[]"  
                                                placeholder="Choose Start Year" class="edustartdatepicker form-control required ">
                                                <span class="error-message education_start_year-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="education_end_year">End Year <span class="danger">*</span></label>
                                                <input type="text" name="education_end_year[]" 
                                                placeholder="Choose End Year" class="form-control required eduenddatepicker">
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
                                </fieldset>
                                <!-- Step 3 -->
                                <h6>Work Experience</h6>
                                <fieldset class="input_experience">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="experiencelevel">Experience Level <span class="danger">*</span></label>
                                                <select class="form-control select2 required" id="experiencelevel" name="experiencelevel[]">
                                                    <option></option>
                                                    <option value="Fresher">Fresher</option>
                                                    <option value="Experienced">Experienced</option>
                                                </select>
                                                <span class="error-message experiencelevel-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="designation">Designation <span class="danger">*</span></label>
                                                <input type="text" class="form-control required" id="designation" name="designation[]">
                                                <span class="error-message designation-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="department">Department <span class="danger">*</span></label>
                                                <input type="text" class="form-control required" id="department" name="department[]">
                                                <span class="error-message department-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="organisation">Organisation <span class="danger">*</span></label>
                                                <input type="text" class="form-control required" id="organisation" name="organisation[]">
                                                <span class="error-message organisation-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="experience_start_year">Start Year <span class="danger">*</span></label>
                                                <input type="text" placeholder="Choose Start Year" name="experience_start_year[]"  class="form-control required expstartdatepicker">
                                                <span class="error-message experience_start_year-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="experience_end_year">End Year <span class="danger">*</span></label>
                                                <input type="text" placeholder="Choose End Year" name="experience_end_year[]" class="form-control required expenddatepicker" id="">
                                                <span class="error-message experience_end_year-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 add_remvoe_btn">
                                            <button class="btn btn-info add_experience">Add Experience</button>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- Step 4 -->
                                <h6>Upload Document</h6>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="resume">Resume <span class="danger">*</span></label>
                                                <input type="file" class="form-control required" id="resume" name="resume" accept=".docx,.doc,.pdf">
                                                <span class="error-message resume-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="profile_pic">Profile Picture</label>
                                                <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                                                <span class="error-message profile_pic-error" style="display: none;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="about">About </label>
                                            <textarea id="about" name="about" class="form-control"></textarea>
                                            <span class="error-message about-error" style="display: none;"></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                            <div id="validation-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script src="{{ asset('app-assets/vendors/js/extensions/jquery.steps.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/wizard-steps.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
//    $('.select2').select2({
//         placeholder: 'Select an option',
//         width: '100%'
//     });
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
                 '<option value="{{$EducationalLevel->name}}">{{$EducationalLevel->name}}</option>'+
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
                '<input type="text" name="education_start_year[]"  placeholder="Choose Start Year" class="edustartdatepicker form-control required ">'+
                '<span class="error-message education_start_year-error" style="display: none;"></span>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
           ' <div class="form-group">'+
                '<label for="education_end_year">End Year <span class="danger">*</span></label>'+
                '<input type="text" name="education_end_year[]" placeholder="Choose End Year" class="form-control required eduenddatepicker">'+
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
                   ' <input type="text" placeholder="Choose Start Year" name="experience_start_year[]"  class="form-control required expstartdatepicker">'+
                   ' <span class="error-message experience_start_year-error" style="display: none;"></span>'+
                '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
               ' <div class="form-group">'+
                    '<label for="experience_end_year">End Year</label>'+
                   ' <input type="text" placeholder="Choose End Year" name="experience_end_year[]" class="form-control required expenddatepicker" id="">'+
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
    $('.wizard .actions').find('a[href="#previous"]').addClass("btn btn-info");
    $('.wizard .actions').find('a[href="#next"]').addClass("btn btn-danger");
    $('.wizard .actions li:last-child').append('<button type="submit" id="submit" class="btn btn-success">Save</button>');
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

    $('#candidate-registration').submit( function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('common.candidate.store') }}",
            data: new FormData(this),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData:false,
            success: function(response) {
                console.log(response);
                $('#submit_button').prop('disabled',false).text('Signup');
                $('.success').css('display', 'block').fadeIn('slow').text("You have registered successfully! Please check your email for login link").delay(3500).fadeOut('slow');
                $('#candidate-update').trigger("reset");
                alert("Profile Created Successfully !");
                window.location.href = "{{ route('common.candidate.index') }}";
            },
            error: function(response) {
                $('#submit_button').prop('disabled',false).text('Signup');
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
<script>
$(document).ready(function(){
    $('#education_start_year').blur(function(){
        $('#education_end_year').val(0-0-0);
        var last_date = $('#education_start_year').val();
        $('#education_end_year').attr('min',last_date);
    });
    $('#experience_start_year').blur(function(){
        $('#experience_end_year').val(0-0-0);
        var last_date = $('#education_start_year').val();
        $('#experience_end_year').attr('min',last_date);
    });
});
</script>
<!-- jquery datepicker -->

<script>
   $(document).ready(function(){

$( function() {
  $("#datepicker" ).datepicker({  changeMonth: true, 
    changeYear: true, dateFormat: 'yy-mm-dd' });
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