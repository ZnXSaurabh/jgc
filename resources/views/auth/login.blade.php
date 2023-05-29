@extends('layouts.web')
@section('content')
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url(front/images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header wform">
                        <div class="inner-title2">
                            <h3>Login</h3>
                            <span>Keep up to date with the latest news</span>
                        </div>
                        <div class="page-breacrumbs">
                            <ul class="breadcrumbs">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Pages</a></li>
                                <li><a href="#">Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="block remove-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="account-popup-area signin-popup-box static">
                        <div class="account-popup">
                            <span>Lorem ipsum dolor sit amet consectetur adipiscing elit odio duis risus at lobortis ullamcorper</span>
                            @if(\Session::has('message'))
                            <p class="alert alert-info">
                                {{ \Session::get('message') }}
                            </p>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="cfield">
                                    <input type="email" name="email" required="required" placeholder="{{ trans('global.login_email') }}">
                                    <i class="la la-user"></i>
                                    @if($errors->has('email'))
                                    <p class="help-block">
                                        {{ $errors->first('email') }}
                                    </p>
                                    @endif
                                </div>
                                <div class="cfield">
                                    <input type="password" name="password" required="required" autofocus="" placeholder="{{ trans('global.login_password') }}">
                                    <i class="la la-key"></i>
                                    @if($errors->has('password'))
                                    <p class="help-block">
                                        {{ $errors->first('password') }}
                                    </p>
                                    @endif
                                </div>
                                <p class="remember-label">
                                    <input type="checkbox" name="remember" id="cb1"><label for="cb1">{{ trans('global.remember_me') }}</label>
                                </p>
                                <a href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a>
                                <button type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

     <script>window.location = "/";</script>
