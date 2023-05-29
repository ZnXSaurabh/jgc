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
                    <h4 class="card-title">Edit Vendor</h4>
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
                        <form action="{{ route('admin.vendor.update',$vendor->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name">Name *</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($vendor) ? $vendor->user->name : '') }}">
                                    @if($errors->has('name'))
                                    <p class="help-block">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email">Email *</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($vendor) ? $vendor->user->email : '') }}">
                                    @if($errors->has('email'))
                                    <p class="help-block">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="city">Phone *</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', isset($vendor) ? $vendor->user->phone : '') }}">
                                    @if($errors->has('phone'))
                                    <p class="help-block">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('city') ? 'has-error' : '' }}">
                                    <label for="city">City *</label>
                                    <input type="text" id="city" name="city" class="form-control" value="{{ $vendor->city}}">
                                    @if($errors->has('city'))
                                    <p class="help-block">{{ $errors->first('city') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('state') ? 'has-error' : '' }}">
                                    <label for="state">State</label>
                                    <input type="text" id="state" name="state" class="form-control" value="{{ $vendor->state}}">
                                    @if($errors->has('state'))
                                    <p class="help-block">{{ $errors->first('state') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('country') ? 'has-error' : '' }}">
                                    <label for="country">Country</label>
                                    <select name="country" id="country" class="form-control select2">
                                        <option></option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->name}}"  {{ old('country', $country->name == $vendor->country) ? 'selected' : '' }}>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('country'))
                                    <p class="help-block">{{ $errors->first('country') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('zip_code') ? 'has-error' : '' }}">
                                    <label for="zip_code">Zip Code *</label>
                                    <input type="text" id="zip_code" name="zip_code" class="form-control" value="{{ $vendor->zip_code}}">
                                    @if($errors->has('zip_code'))
                                    <p class="help-block">{{ $errors->first('zip_code') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label for="address">Address *</label>
                                    <input type="text" name="address" class="form-control" value="{{ $vendor->address}}">
                                    @if($errors->has('address'))
                                    <p class="help-block">{{ $errors->first('address') }}</p>
                                    @endif
                                </div>
                                <div class="form-group col-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label for="status">Choose Status</label>
                                    <select name="status" id="status" class="form-control select2" required>
                                        @if($vendor->status == '1')
                                        <option value="1" selected>Activate</option>
                                        <option value="0">Deactivate</option>
                                        @elseif($vendor->status == '0')
                                        <option value="0" selected>Deactivate</option>
                                        <option value="1">Activate</option>
                                        @endif
                                    </select>
                                    @if($errors->has('status'))
                                    <p class="help-block">{{ $errors->first('status') }}</p>
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