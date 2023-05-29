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
					<h4 class="card-title">Create HR Manager</h4>
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-danger" href="{{ route('admin.hr_manager.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
							</div>
						</div>
					</div>
				</div>
				@if(session('error'))
                <div class="alert alert-icon-right alert-danger alert-dismissible mb-2" role="alert">
                    <span class="alert-icon">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
                    </span>
                    <strong>{!! session('error') !!}</strong>
                </div>
                @endif
				<div class="card-content collapse show">
					<div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">
						<form action="{{ route('admin.hr_manager.store') }}" method="post" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="row">
								<div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : '' }}">
									<label for="name">Name *</label>
									<input type="text" name="name" value="{{ old('name') }}" class="form-control">
									@if($errors->has('name'))
									<p class="text-danger">{{ $errors->first('name') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('email') ? 'has-error' : '' }}">
									<label for="email">Email *</label>
									<input type="email" value="{{ old('email') }}" name="email" class="form-control" >
									@if($errors->has('email'))
									<p class="text-danger">{{ $errors->first('email') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('employee_no') ? 'has-error' : '' }}">
									<label for="employee_no">Employee Number *</label>
									<input type="text" value="{{ old('employee_no') }}" name="employee_no" class="form-control">
									@if($errors->has('employee_no'))
									<p class="text-danger">{{ $errors->first('employee_no') }}</p>
									@endif
								</div>
								<!-- <div class="form-group col-md-6 {{ $errors->has('phone') ? 'has-error' : '' }}">
									<label for="phone">Phone *</label>
									<input type="text" name="phone" id="phone" class="form-control" >
									@if($errors->has('phone'))
									<p class="text-danger">{{ $errors->first('phone') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('pincode') ? 'has-error' : '' }}">
									<label for="pincode">Zip/Postal Code *</label>
									<input type="text" name="pincode" class="form-control">
									@if($errors->has('pincode'))
									<p class="text-danger">{{ $errors->first('pincode') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('address') ? 'has-error' : '' }}">
									<label for="address">Address *</label>
									<input type="text" name="address" class="form-control" >
									@if($errors->has('address'))
									<p class="text-danger">{{ $errors->first('address') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('city') ? 'has-error' : '' }}">
									<label for="organisation">City *</label>
									<input type="text" name="city" class="form-control" >
									@if($errors->has('city'))
									<p class="text-danger">{{ $errors->first('city') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('state') ? 'has-error' : '' }}">
									<label for="state">State *</label>
									<input type="text" name="state" class="form-control" >
									@if($errors->has('state'))
									<p class="text-danger">{{ $errors->first('state') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('country') ? 'has-error' : '' }}">
									<label for="country">Country *</label>
									<select name="country" id="country" class="form-control select2" required>
										<option></option>
										@foreach($countries as $country)
										<option value="{{$country->name}}">{{$country->name}}</option>
										@endforeach
									</select>
									@if($errors->has('country'))
									<p class="text-danger">{{ $errors->first('country') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('dob') ? 'has-error' : '' }}">
									<label for="dob">Date Of Birth *</label>
									<input type="date" name="dob" class="form-control"  max="{{ date('Y-m-d', strtotime('-18 years')) }}"  min="{{ date('Y-m-d', strtotime('-70 years')) }}">
									@if($errors->has('dob'))
									<p class="text-danger">{{ $errors->first('dob') }}</p>
									@endif
								</div>
								<div class="form-group col-md-6 {{ $errors->has('gender') ? 'has-error' : '' }}">
									<label for="gender">Gender *</label>
									<select name="gender" class="form-control select2">
										<option></option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
										<option value="Other">Other</option>
									</select>
									@if($errors->has('gender'))
									<p class="text-danger">{{ $errors->first('gender') }}</p>
									@endif
								</div>
								<div class="form-group col-md-12 {{ $errors->has('about') ? 'has-error' : '' }}">
									<label for="about">About *</label>
									<textarea name="about" class="form-control"></textarea>
									@if($errors->has('about'))
									<p class="text-danger">{{ $errors->first('about') }}</p>
									@endif
								</div> -->
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
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
$('.select2').select2({
	placeholder: 'Select an option'
});
CKEDITOR.replace('about');
</script>
@endsection
@endsection