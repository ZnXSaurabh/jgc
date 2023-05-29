@extends('layouts.web')
@section('content')
<section class="overlape">
    <div class="block no-padding">
        <div class="container fluid">
            <div class="inner-header wform" style="background: url(front/images/kfupm1.png);
    background-position-y: bottom;"><h1 class= "text-center text-danger font-weight-bold py-2">KFUPM REGISTRATION </h1>
            </div>
            
        </div>
    </div>
</section>
<section class="kfupm-form">
    <div>
        @if(Session::has('status'))
        <p class="text-success pl-4 ml-4">{{session('status')}}</p>
        @endif
    </div>
    
    @if(count($errors))
            <div class="form-group">
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    <div>
        <form method="post" enctype="multipart/form-data" action="{{url('kfupmregister')}}">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Candidate Name:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Candidate Name"
                            required="" />
                        <div class="icons">
                            <i class="la la-user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label>Email Address:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address"
                            required="" />
                        <div class="icons">
                            <i class="la la-envelope-o"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Mobile NO:<span class="text-danger">&nbsp;*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="mobile">+966</span>
                        </div>
                        <div class="form-icon">
                            <input type="text"
                            name="mobile"
                            id="mobile"
                            aria-describedby="basic-addon"
                            maxlength="9"
                            class="form-control"
                            placeholder="Mobile NO."
                            onkeypress="if(this.value.length >= this.getAttribute('maxlength') return false;"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            required="" />
                            <div class="icons">
                                <i class="la la-phone"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label>Select Student Type:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon">
                        <select name="student" id="student" class="form-select" required="">
                            <option></option>
                            <option value="KFUPM Student">KFUPM Student</option>
                            <option value="KFUPM Alumnus">KFUPM Alumnus</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div id="otherStd">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>National ID/ Iqama:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon">
                        <input type="text" name="national_id" id="national_id" class="form-control"
                            placeholder="National ID/ Iqama." required="" />
                        <div class="icons">
                            <i class="la la-flag-checkered"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label>Major:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon">
                        <input type="text" name="major" id="major" class="form-control" placeholder="Major"
                            required="" />
                        <div class="icons">
                            <i class="la la-leanpub"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>Select Degree Level:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon">
                        <select name="degree" id="degree" class="form-select" required="">
                            <option></option>
                            <option value="Masters">Masters</option>
                            <option value="Batchelor">Batchelor</option>
                            <option value="Diploma">Diploma</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div id="otherDg"></div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label>University/College/School:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon">
                        <input type="text" name="university" id="university" class="form-control"
                            placeholder="University/College/School:" required="" />
                        <div class="icons">
                            <i class="la la-graduation-cap"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kfupm-warning text-danger">*file type should be pdf and file size should be less than 4mb</div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label>CV Upload:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon tooltip">
                        <div class="kfupm-file">
                            <input type="file" name="cv" id="cv" accept=".docx,.doc,.pdf" required="" />
                            <span class="tooltiptext text-danger" id="cvSizeError">File size must be below 4mb</span>
                            <span class="tooltiptext text-danger" id="cvTypeError">File type must be PDF/DOCX/DOC</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label>Certificate & Supporting Documents Upload:<span class="text-danger">&nbsp;*</span></label>
                    <div class="form-icon tooltip">
                        <div class="kfupm-file">
                            <input type="file" name="certificate" id="certificate" accept=".docx,.doc,.pdf"
                                required="" />
                            <span class="tooltiptext text-danger" id="sizeError">File size must be below 4mb</span>
                            <span class="tooltiptext text-danger" id="certificateTypeError">File type must be PDF/DOCX/DOC</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5 d-flex justify-content-center">
                <button class="" type="submit">Register</button>
            </div>
        </form>
</section>
@endsection
@section('scripts')

<script>


    $('#student').on('change', function () {
        if (this.value == 'others') {
            return $('#otherStudent').css({
                display: "block"
            });
        }
        $('#otherStudent').css({
            display: "none"
        });
    });



    $('#certificate').on('change', function () {
        if(this.files[0].type == 'application/msword' || this.files[0].type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || this.files[0].type == 'application/pdf'){
        if (this.files[0].size > 4000000) {
            $(this).val('');
            $("#certificateTypeError").hide();
            $("#sizeError").show();
            return setTimeout(function () {
                $("#sizeError").hide();
            }, 4000);
        }
        $("#certificateTypeError").hide();
        $("#sizeError").hide();
    }
    else{
            $(this).val('');
            $("#sizeError").hide();
            $("#certificateTypeError").show();
            return setTimeout(function () {
                $("#sizeError").hide();
            }, 4000);
        }
    });




    $('#cv').on('change', function () {
        if(this.files[0].type == 'application/msword' || this.files[0].type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || this.files[0].type == 'application/pdf'){
        if (this.files[0].size > 4000000) {
            $(this).val('');
            $("#cvTypeError").hide();
            $("#cvSizeError").show();
            return setTimeout(function () {
                $("#cvSizeError").hide();
            }, 4000);
        }
        $("#cvTypeError").hide();
        $("#cvSizeError").hide();
        }
        else{
            $(this).val('');
            $("#cvSizeError").hide();
            $("#cvTypeError").show();
            return setTimeout(function () {
                $("#cvSizeError").hide();
            }, 4000);

        }
    });



    $('#degree').on('change', function () {
        if (this.value == 'others') {
            return $('#otherDg').html(
                "<input type=\"text\" name=\"otherDegree\" id=\"otherDegree\" class=\"form-control mt-2\" placeholder=\"Enter Your Degree Level.\"  required=\"\">"
            );
        }
        $('#otherDegree').remove();
    });




    $('#student').on('change', function () {
        if (this.value == 'others') {
            return $('#otherStd').html(
                "<input type=\"text\" name=\"otherStudent\" id=\"otherStudent\" class=\"form-control mt-2\" placeholder=\"Enter Your Student Type.\"  required=\"\">"
            );
        }
        $('#otherStudent').remove();
    });

    // $("#mobile").intlTelInput({
    // 	utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    // });

</script>
@endsection
