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
                    <h4 class="card-title">Create Vendor</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-danger" href="{{ route('admin.vendor.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
                        <form action="{{ route('admin.vendor.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name">Full Name *</label>
                                    <input type="text" id="name" value="{{ old('name') }}" name="name" class="form-control" >
                                    @if($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email">Email *</label>
                                    <input type="text" id="email" value="{{ old('email') }}" name="email" class="form-control" >
                                    @if($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone">Mobile *</label>
                                    <input type="text" id="phone" value="{{ old('phone') }}" name="phone" class="form-control" >
                                    @if($errors->has('phone'))
                                    <p class="text-danger">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('city') ? 'has-error' : '' }}">
                                    <label for="city">City *</label>
                                    <input type="text" id="city" value="{{ old('city') }}" name="city" class="form-control" >
                                    @if($errors->has('city'))
                                    <p class="text-danger">{{ $errors->first('city') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('state') ? 'has-error' : '' }}">
                                    <label for="state">state</label>
                                    <input type="text" id="state" value="{{ old('state') }}" name="state" class="form-control" >
                                    @if($errors->has('state'))
                                    <p class="text-danger">{{ $errors->first('state') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('zip_code') ? 'has-error' : '' }}">
                                    <label for="zip_code">Zip Code *</label>
                                    <input type="text" id="zip_code" value="{{ old('zip_code') }}" name="zip_code" class="form-control" >
                                    @if($errors->has('zip_code'))
                                    <p class="text-danger">{{ $errors->first('zip_code') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('country') ? 'has-error' : '' }}">
                                    <label for="country">Country</label>
                                    <select name="country" id="country" class="form-control select2" required>
                                        <option></option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->name}}" @if($country->name== old('country')) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('country'))
                                    <p class="text-danger">{{ $errors->first('country') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label for="address">Address *</label>
                                    <input type="text" id="address" value="{{ old('address') }}" name="address" class="form-control" >
                                    @if($errors->has('address'))
                                    <p class="text-danger">{{ $errors->first('address') }}</p>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="{{ asset('app-assets/js/scripts/pages/material-app.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.min.js') }}"></script>
<script>
$('.select2').select2({
placeholder: 'Select an option'
});
</script>
@endsection
@endsection