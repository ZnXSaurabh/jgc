@extends('layouts.admin')
@section('content')
<div class="content-body">
	<section class="users-view">
		<div class="row">
			<div class="col-12 col-sm-7">
				<div class="media mb-2">
					<a class="mr-1" href="#"><img src="{{ asset('app-assets/images/avatar.png') }}" alt="users view avatar" class="users-avatar-shadow rounded-circle" height="64" width="64"></a>
					<div class="media-body pt-25">
						<h4 class="media-heading">
						<span class="users-view-name">{{ $KfupmUser->name ?? '' }} </span><span class="text-muted font-medium-1">#</span><span class="users-view-username text-muted font-medium-1"><em>{{ $KfupmUser->email ?? '' }}</em></span>
						</h4>
						<span>ID:</span>
						<span class="users-view-id">{{ $KfupmUser->id ?? '' }}</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
				<a class="btn btn-sm btn-primary" href="{{ route('admin.kfupm_user.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
			</div>
		</div>
		<!-- users view media object ends -->
		<!-- users view card data start -->
		<!-- users view card data ends -->
		<!-- users view card details start -->
		<div class="card">
			<div class="card-content">
				<div class="card-body">
					<!-- <div class="row bg-primary bg-lighten-5 rounded mb-2 mx-25 text-center text-lg-left">
						<div class="col-12 col-sm-4 p-2">
							<h6 class="text-primary mb-0">Total HR: <span class="font-large-1 align-middle">125</span></h6>
						</div>
						<div class="col-12 col-sm-4 p-2">
							<h6 class="text-primary mb-0">Total Job Approved: <span class="font-large-1 align-middle">534</span></h6>
						</div>
						<div class="col-12 col-sm-4 p-2">
							<h6 class="text-primary mb-0">Total Job Creation: <span class="font-large-1 align-middle">256</span></h6>
						</div>
					</div> -->
					<div class="col-12">
						<table class="table table-borderless">
							<tbody>
								<tr>
									<td>Name:</td>
									<td class="users-view-username">{{ $KfupmUser->name }}</td>
								</tr>
								<tr>
									<td>E-mail:</td>
									<td class="users-view-name">{{ $KfupmUser->email }}</td>
								</tr>
								<!-- <tr>
									<td>Phone:</td>
									<td>{{ $KfupmUser->phone }}</td>
								</tr> -->
								<tr>
									<td>Mobile:</td>
									<td class="users-view-email">{{ $KfupmUser->phone }}</td>
								</tr>
								<tr>
									<td>Student:</td>
									<td class="users-view-email">{{ $KfupmUser->student }}</td>
								</tr>
								<tr>
									<td>National ID:</td>
									<td class="users-view-email">{{ $KfupmUser->national_id }}</td>
								</tr>
								<tr>
									<td>Major:</td>
									<td class="users-view-email">{{ $KfupmUser->major }}</td>
								</tr>
								<tr>
									<td>Degree:</td>
									<td class="users-view-email">{{ $KfupmUser->degree }}</td>
								</tr>
								<tr>
									<td>University:</td>
									<td class="users-view-email">{{ $KfupmUser->university }}</td>
								</tr>
								<tr>
									<td>CV:</td>
									<td class="users-view-email"><a href="https://career.jgc.com.sa/public/KFUPM/CV/{{ $KfupmUser->cv }}" target="_blank"><i class="material-icons inside-icons">visibility</i>{{ $KfupmUser->cv }}</a></td>
								</tr>
								<tr>
									<td>Certificate:</td>
									<td class="users-view-email"><a href="https://career.jgc.com.sa/public/KFUPM/Certificate/{{ $KfupmUser->certificate }}" target="_blank"><i class="material-icons inside-icons">visibility</i>{{ $KfupmUser->certificate }}</a></td>
								</tr>
								<tr>
									<td>Register Date:</td>
									<td class="users-view-email">{{ date('d-m-Y', strtotime($KfupmUser->created_at))  ?? '' }}</td>
								</tr>
							</tbody>
						</table>
						<!-- <h5 class="mb-1"><span class="material-icons">info</span> Personal Info</h5>
						<table class="table table-borderless mb-0">
							<tbody>
								<tr>
									<td>Birthday:</td>
									<td>{{ $KfupmUser}}</td>
								</tr>
								<tr>
									<td>Country:</td>
									<td>{{ $KfupmUsertry }}</td>
								</tr>
								<tr>
									<td>City:</td>
									<td>{{ $KfupmUser }}</td>
								</tr>
								<tr>
									<td>Address:</td>
									<td>{{ $KfupmUseress }} @if($KfupmUseress2){{ $KfupmUseress2 }}@endif</td>
								</tr>
								<tr>
									<td>Gender:</td>
									<td>{{ $KfupmUserer }}</td>
								</tr>
							</tbody>
						</table> -->
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection