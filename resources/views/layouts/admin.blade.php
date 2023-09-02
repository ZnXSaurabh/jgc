<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="GIKSINDIA">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('global.site_title') }}</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/site-icon.jpg') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/material-icons/material-icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/material-vendors.min.css') }}">
    <!-- END: Vendor CSS-->
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/material.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/material-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/material-colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/material-vertical-menu-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">
    <!-- jquery datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https:://jqueryui.com/resources/demos/style.css">
    <!-- End jquery datepicker -->
    <style>
    .intl-tel-input {
      display: block;
    }
    .intl-tel-input .selected-flag {
      z-index: 4;
    }
    .intl-tel-input .country-list {
      z-index: 5;
    }
    </style>
    @yield('styles')
  </head>
  <body class="vertical-layout vertical-menu-modern material-vertical-layout material-layout 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- BEGIN: Header-->
    @include('partials.app-header')
    <!-- END: Header-->
    <!-- BEGIN: Main Menu-->
    @include('partials.app-menu')
    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-header row"></div>
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        @yield('content')
      </div>
    </div>
  </div>
</div>
<!-- END: Content-->
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-border navbar-shadow">
  <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-center d-block d-md-inline-block">{{ trans('global.site_title') }}<strong >  &copy; {{ date("Y") }}  Giks</strong></span></p>
</footer>
<!-- END: Footer-->
<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<script src="{{ asset('app-assets/vendors/js/material-vendors.min.js') }}"></script>

<script src="{{ asset('app-assets/js/core/app-menu.min.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.min.js') }}"></script>
<!-- <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script> -->
<!-- <script src="{{ asset('app-assets/js/scripts/footer.min.js') }}"></script> -->
@yield('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
<script>
$("#phone").intlTelInput({
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
});
</script>
</body>
</html>