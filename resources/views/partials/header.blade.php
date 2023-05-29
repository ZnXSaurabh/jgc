<div class="responsive-header">
	<div class="responsive-menubar">
		<div class="res-logo"><a href="{{ url('/') }}" title=""><img  src="{{ asset('images/jgc-logo-white.jpg') }}" alt="" /></a></div>
		<div class="menu-resaction">
			<div class="res-openmenu">
				<img src="{{ asset('front/images/icon.png') }}" alt="" /> Menu
			</div>
			<div class="res-closemenu">
				<img src="{{ asset('front/images/icon2.png') }}" alt="" /> Close
			</div>
		</div>
	</div>
	<div class="responsive-opensec">
		<div class="btn-extars">
		    <!--@if(! Route::is('kfupmregister'))
		    <ul class="account-btns">
					<li class="kfupm-popup"><a href="{{ route('kfupmregister') }}" title=""><i class="la la-file-text"></i>KFUPM Register</a></li>
			</ul>
			@endif-->
			<a href="{{ route('browse-jobs') }}" title="" class="post-job-btn"><i class="la la-search"></i>Browse Jobs</a>
			<ul class="account-btns">
				@if(Auth::user())
				<div class="my-profiles-sec">
					<span class="auth_user_name"> Hello {{ Auth::user()->name }}</span>
				</div>
				@else
				<li class="signup-popup"><a title=""><i class="la la-key"></i> Sign Up</a></li>
				<li class="signin-popup"><a title=""><i class="la la-external-link-square"></i> Login</a></li>
				@endif
			</ul>
		</div>
		<form class="res-search">
			<input type="text" placeholder="Job title, keywords or company name" />
			<button type="submit"><i class="la la-search"></i></button>
		</form>
		<div class="responsivemenu">
			<ul>
				@if(Auth::user() && Auth::user()->hasRole('Super Admin'))
				<li><a href="{{ route('common.dashboard')}}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
				@elseif(Auth::user() && Auth::user()->hasRole('Admin'))
				<li><a href="{{ route('common.dashboard')}}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
				@elseif(Auth::user() && Auth::user()->hasRole('HR'))
				<li><a href="{{ route('common.dashboard') }}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
				@elseif(Auth::user() && Auth::user()->hasRole('Vendor'))
				<li><a href="{{ route('common.dashboard') }}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
				@elseif(Auth::user() && Auth::user()->hasRole('HR Manager'))
				<li><a href="{{ route('common.dashboard') }}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
				@elseif(Auth::user() && Auth::user()->hasRole('Candidate'))
				<li><a href="{{ route('common.candidate-profile') }}" title=""><i class="la la-file-text"></i>My Profile</a></li>
				<li><a href="{{ route('common.candidate.edit', Auth::user()->id) }}" title=""><i class="la la-file-text"></i>Update Profile</a></li>
				<li><a href="{{ route('common.applied_jobs_by_candidate') }}" title=""><i class="la la-paper-plane"></i>Applied Jobs</a></li>
				@endif
				@if(Auth::user())
				<li><a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="la la-unlink"></i> {{ trans('global.logout') }}</a></li>
				@endif
			</ul>
		</div>
	</div>
</div>
<header class="stick-top forsticky new-header">
	<div class="menu-sec">
		<div class="container">
			<div class="logo">
				<a href="{{ url('/') }}" title="">
					<!-- <img class="hidesticky" src="{{ asset('images/logo.png') }}" alt="" /> -->
					<img class="showsticky" src="{{ asset('images/logo-black.png') }}" alt="" />
				</a>
			</div>
			@if(Auth::user())
			<div class="my-profiles-sec">
				<span>Hello {{ Auth::user()->name }}<i class="la la-bars"></i></span>
			</div>
			@endif
			<div class="btn-extars">
			<!--@if(! Route::is('kfupmregister'))
		    <ul class="account-btns">
					<li class="kfupm-popup"><a href="{{ route('kfupmregister') }}" title=""><i class="la la-file-text"></i>KFUPM Register</a></li>
			</ul>
			@endif-->
			@if(! Route::is('browse-jobs'))
				<a href="{{ route('browse-jobs') }}" title="" class="post-job-btn"><i class="la la-search"></i>Browse Job</a>
				@endif
				@if(!Auth::user())
				<ul class="account-btns">
					<li class="signup-popup"><a title=""><i class="la la-key"></i> Sign Up</a></li>
					<li class="signin-popup"><a title=""><i class="la la-external-link-square"></i> Login</a></li>
				</ul>
				@endif
			</div>
		</div>
	</div>
</header>
<div class="profile-sidebar">
	<span class="close-profile"><i class="la la-close"></i></span>
	<div class="can-detail-s">
		@if(Auth::user() && Auth::user()->profile->profile_pic != null)
		<div class="cst"><img src="{{ \Illuminate\Support\Facades\Storage::url('profile_pic/'. Auth::user()->id .'/'. Auth::user()->profile->profile_pic) }}" alt="" /></div>
		@else
		<div class="cst"><img src="{{ asset('app-assets/images/avatar.png') }}" alt="" /></div>
		@endif
		@if(Auth::user())
		<h3>{{ Auth::user()->name }}</h3>
		<p>{{ Auth::user()->email }}</p>
		@endif
	</div>
	<div class="tree_widget-sec">
		<ul>
			@if(Auth::user() && Auth::user()->hasRole('Super Admin'))
			<li><a href="{{ route('common.dashboard')}}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
			@elseif(Auth::user() && Auth::user()->hasRole('Admin'))
			<li><a href="{{ route('common.dashboard')}}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
			@elseif(Auth::user() && Auth::user()->hasRole('HR'))
			<li><a href="{{ route('common.dashboard') }}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
			@elseif(Auth::user() && Auth::user()->hasRole('Vendor'))
			<li><a href="{{ route('common.dashboard') }}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
			@elseif(Auth::user() && Auth::user()->hasRole('HR Manager'))
			<li><a href="{{ route('common.dashboard') }}" title=""><i class="la la-file-text"></i>Dashboard</a></li>
			@elseif(Auth::user() && Auth::user()->hasRole('Candidate'))
			<li><a href="{{ route('common.candidate-profile') }}" title=""><i class="la la-file-text"></i>My Profile</a></li>
			<li><a href="{{ route('common.candidate.edit',Auth::user()->id) }}" title=""><i class="la la-file-text"></i>Update Profile</a></li>
			<li><a href="{{ route('common.applied_jobs_by_candidate') }}" title=""><i class="la la-paper-plane"></i>Applied Job</a></li>
			@endif
			<li><a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="la la-unlink"></i> {{ trans('global.logout') }}</a></li>
		</ul>
	</div>
</div>