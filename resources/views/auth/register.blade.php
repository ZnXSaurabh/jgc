@extends('layouts.app')
<style  nonce="{{ csp_nonce() }}">
.intl-tel-input {
    display: table-cell;
}
.intl-tel-input .selected-flag {
    z-index: 4;
}
.intl-tel-input .country-list {
    z-index: 5;
}
.input-group .intl-tel-input .form-control {
    border-top-left-radius: 4px;
    border-top-right-radius: 0;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 0;
}
</style>
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="#">
        {{ trans('global.register') }}
        </a>
    </div>
    <div class="login-box-body">
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div>
                <div class="form-group has-feedback">
                    <div class="row">
                        <div class="col-md-4">                            
                            Candidate
                        </div>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="name" class="form-control" required="required"="autofocus" placeholder="{{ trans('global.user_name') }}">
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" required="required" placeholder="{{ trans('global.login_email') }}">
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" required="required" placeholder="{{ trans('global.login_password') }}">
                    @if($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password_confirmation" class="form-control" required="required" placeholder="{{ trans('global.login_password_confirmation') }}">
                    @if($errors->has('password_confirmation'))
                        <p class="help-block">
                            {{ $errors->first('password_confirmation') }}
                        </p>
                    @endif
                </div>
                <div class="form-group has-feedback">
                    <input type="mobile" name="phone" class="form-control" required="required" placeholder="Phone"> 
                </div>
                <div class="form-group has-feedback">
                    <select name="country_id">
                    <option value="default">Choose country..</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-xs-8">

                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            {{ trans('global.register') }}
                        </button>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection