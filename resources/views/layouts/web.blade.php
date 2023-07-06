<!DOCTYPE html>
<html>
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta name="author" content="GIKSINDIA">
		<title>{{ trans('global.site_title') }}</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link rel="icon" href="{{ asset('images/site-icon.jpg') }}" sizes="32x32">
		<!-- Styles -->
		<link rel="stylesheet" href="{{ asset('front/css/bootstrap-grid.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/icons.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/animate.min.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/chosen.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/colors/colors.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('front/css/font-awesome.min.css') }}">
		    <!-- jquery datepicker -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https:://jqueryui.com/resources/demos/style.css">
<!-- End jquery datepicker -->
		@yield('styles')
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">
		<style>
		.intl-tel-input {
		  display: table-cell;
		}
		.intl-tel-input .selected-flag {
		  z-index: 4;
		}
		.intl-tel-input .country-list {
		  z-index: 5;
		}
		.cfield .intl-tel-input .form-control {
		  border-top-left-radius: 4px;
		  border-top-right-radius: 0;
		  border-bottom-left-radius: 4px;
		  border-bottom-right-radius: 0;
		}
		</style>
	</head>
	<body class="newbg">
		<div class="page-loading">
			<div id="fountainTextG"><div id="fountainTextG_1" class="fountainTextG">J</div><div id="fountainTextG_2" class="fountainTextG">G</div><div id="fountainTextG_3" class="fountainTextG">C</div><div id="fountainTextG_4" class="fountainTextG"> </div><div id="fountainTextG_5" class="fountainTextG">G</div><div id="fountainTextG_6" class="fountainTextG">U</div><div id="fountainTextG_7" class="fountainTextG">L</div><div id="fountainTextG_8" class="fountainTextG">F</div></div>
		</div>
		<div class="theme-layout" id="scrollup">
			@include('partials.header')
			@yield('content')
			@include('partials.footer')
		</div>
		<div class="account-popup-area signin-popup-box">
			<div class="account-popup">
				<span class="close-popup"><i class="la la-close"></i></span>
				<h3>Login</h3>
				<span class="text-success login_success" style="display: none;"></span>
				<form class="login-form" id="loginForm">
					<div class="cfield log-form">
						<input type="email" name="email" id="login_email" placeholder="Email" required="">
						<i class="la la-user"></i>
						<span class="error-message login-email-error" style="display: none;"></span>
					</div>
					<div class="remember-label ">
						<label class="signup-popup">Not Register Yet? <a href="javascript:void(0)" id="signup_model" class="text-danger">Register Here</a></label>
					</div>
					<button class="log-form" id="login_button" type="submit"  >Login</button>
					</br>
					<div classNmae="text-center">
				
					<a href="#" id="resendLoginEmail" value="" class="text-danger text-center" style="display:none">Resend Email</a>
					</div>
				</form>
			</div>
		</div>
		<div class="account-popup-area signup-popup-box">
			<div class="account-popup">
				<span class="close-popup"><i class="la la-close"></i></span>
				<h3>Sign Up</h3>
				<span class="success" style="display: none;"></span>
				<form class="register-form" id="registerForm">
					<div class="cfield reg-form">
						<input type="text" id="fullname" name="name" placeholder="Fullname" >
						<i class="la la-user"></i>
						<span class="error-message fullname-error" style="display: none;"></span>
					</div>
					<div class="cfield reg-form">
						<input type="email" name="email" id="email" placeholder="Email" >
						<i class="la la-envelope-o"></i>
						<span class="error-message email-error" style="display: none;"></span>
					</div>
					<div class="cfield reg-form">
						<input type="tel" name="phone" id="phone" placeholder="Phone Number" >
						<i class="la la-phone"></i>
						<span class="error-message phone-error" style="display: none;"></span>
					</div>
					<div id="captachaDiv">
					<div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
						<p id="checkRegisterCaptcha"  style="color:red;font-size:15px;"></p>
					</div>
					<button class="reg-form" id="submit_button" type="submit" style="margin-top: 93px;">Signup</button>
					<span class="signin-popup">Already Register ?
						<a href="javascript:void(0)" id="signin_model" class="text-danger">Login Here</a>
					</span>
					</br>
					<div classNmae="text-center">
					<a href="#" id="resendEmail" value="" class="text-primary text-center" style="display:none">Resend Email</a>
					</div>
				</form>
			</div>
		</div>
		<form id="logoutform" action="{{route('logout')}}" method="POST" style="display:none;">
			{{ csrf_field() }}
		</form>
		<script data-cfasync="false" src="{{ asset('front/js/email-decode.min.js') }}"></script>
		<!-- <script src="{{ asset('front/js/jquery.min.js') }}" type="text/javascript"></script> -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="{{ asset('front/js/modernizr.js') }}" type="text/javascript"></script>
		<script src="{{ asset('front/js/script.js') }}" type="text/javascript"></script>
		<script src="{{ asset('front/js/bootstrap.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('front/js/wow.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('front/js/slick.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('front/js/parallax.js') }}" type="text/javascript"></script>
		<script src="{{ asset('front/js/select-chosen.js') }}" type="text/javascript"></script>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
			
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
		
		<script>
		$(document).ready(function(){
			$("#phone").intlTelInput({
				utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js",
				initialCountry: "sa"
			});
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
				}
			});

			$('.login-form').submit(function(event) {
    event.preventDefault();

        $('#login_button').prop('disabled', true).text('Please wait...');
        
        var postData = {
            'email': $('#login_email').val(),
        };
        
        $('#resendLoginEmail').val(postData);
        
        $.ajax({
            type: 'POST',
            url: "/login_link",
            data: postData,
            success: function(response) {
                $('#resendLoginEmail').css('display', 'block').delay(3500);
                $('#login_button').prop('disabled', false).text('Login');
				$('#captachaDiv').css('display', 'none');
                $('.login_success').css('display', 'block').fadeIn('slow').text("Check your email for login link").delay(3500);
                $('form.register-form').trigger("reset");
                $('.log-form').css('display', 'none');
            },
            error: function(response) {
                $('#login_button').prop('disabled', false).text('Login');
                $('.error-message').css('display', 'none');
                if (response) {
                    if (response.responseJSON.errors.email) {
                        $('.login-email-error').css('display', 'block').html(response.responseJSON.errors.email);
                        $('.login-email-error').siblings("input").addClass("error-line");
                    }
                }
            }
        });
        });
});


			$('#signin_model').click(function(){
				$('.signup-popup-box').css('display','none');
			});
			$('#signup_model').click(function(){
				$('.signin-popup-box').css('display','none');
			});

		// Register Form Ajax Request
$('.register-form').submit(function(event) {
    $('#submit_button').prop('disabled', true).text('Please wait...');
    event.preventDefault();
    var postData = {
        'name': $('#fullname').val(),
        'email': $('#email').val(),
        'phone': $('#phone').val(),
    };
    $('#resendEmail').val(postData);
    
	var recaptchaResponse = grecaptcha.getResponse();

	if(recaptchaResponse && recaptchaResponse.length > 0){

			postData['g-recaptcha-response'] = recaptchaResponse;
            // Process Form 2 submission
            $.ajax({
        type: 'POST',
        url: "/register",
        data: postData,
        success: function(response) {
            $('#resendEmail').css('display', 'block').delay(3500);
            $('#submit_button').prop('disabled', false).text('Signup');
            $('.success').css('display', 'block').addClass('text-success').fadeIn('slow').text("You have registered successfully! Please check your email for login link").delay(3500);
            $('form.register-form').trigger("reset");
            $('.reg-form').css('display', 'none');
			$('.g-recaptcha').css('display', 'none'); 
        },
        error: function(response) {
            $('#submit_button').prop('disabled', false).text('Signup');
            $('.error-message').css('display', 'none');
            if (response) {
                if (response.responseJSON.errors.name) {
                    $('.fullname-error').css('display', 'block').html(response.responseJSON.errors.name);
                    $('.fullname-error').siblings("input").addClass("error-line");
                }
                if (response.responseJSON.errors.email) {
                    $('.email-error').css('display', 'block').html(response.responseJSON.errors.email);
                    $('.email-error').siblings("input").addClass("error-line");
                }
                if (response.responseJSON.errors.phone) {
                    $('.phone-error').css('display', 'block').html(response.responseJSON.errors.phone);
                    $('.phone-error').siblings("input").addClass("error-line");
                }
            }
        }
    });
}
 else {
            // Display an error message or take appropriate action
			document.getElementById("checkRegisterCaptcha").innerHTML = "reCAPTCHA not checked!";
        	$('#submit_button').prop('disabled', false).text('Signup');
          }
    
});


			$('#resendEmail').click(function(event) {
				$('#resendEmail').css('display','none');
				$('#submit_button').prop('disabled',true).text('Please wait...');
				event.preventDefault();
				 var postData = $('#resendEmail').val();
				$.ajax({
					type: 'POST',
					url: "/resend_email",
					data: postData,
					success: function(response) {
						$('#resendEmail').css('display','none');
						$('#submit_button').prop('disabled',false).text('Signup');
						$('.success').css('display', 'block').addClass('text-success').fadeIn('slow').text("Email resend successfully !").delay(3500);
						$('form.register-form').trigger("reset");
					},
				});
			});
			$('#resendLoginEmail').click(function(event) {
				$('#resendLoginEmail').css('display','none');
				$('#submit_button').prop('disabled',true).text('Please wait...');
				event.preventDefault();
				 var postData = $('#resendLoginEmail').val();
				$.ajax({
					type: 'POST',
					url: "/resend_login_email",
					data: postData,
					success: function(response) {
						$('#resendLoginEmail').css('display','none');
						$('#login_button').prop('disabled',false).text('Login');
						$('.login_success').css('display', 'block').addClass('text-success').fadeIn('slow').text("Email resend successfully !").delay(3500);
						$('form.register-form').trigger("reset");
					},
				});
			});
		// Navbar on scroll
		$(document).ready(function () {
		    var didScroll;
		    var lastScrollTop = 0;
		    var delta = 5;
		    var navbarHeight = $(".page-header").outerHeight();
		    $(window).scroll(function (event) {
		        didScroll = true;
		    });
		    setInterval(function () {
		        if (didScroll) {
		            hasScrolled();
		            didScroll = false;
		        }
		    }, 250);

		    function hasScrolled() {
		        var st = $(this).scrollTop();
		        if (Math.abs(lastScrollTop - st) <= delta) return;
		        if (st > lastScrollTop && st > navbarHeight) {
		            $(".page-header").removeClass("nav-down").addClass("nav-up");
		        } else {
		            if (st + $(window).height() < $(document).height()) {
		                $(".page-header").removeClass("nav-up").addClass("nav-down");
		            }
		            if (st == 0) {
		                $(".page-header").removeClass("nav-down");
		            }
		        }
		        lastScrollTop = st;
		    }
		});
		</script>
		@yield('scripts')
		
	</body>
</html>