@extends('layouts.web')
@section('styles')

@endsection
@section('content')
<section class="overlape">
	<div class="block no-padding">
		<div data-velocity="-.1" style="background: url(images/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
		<div class="container fluid">
			<div class="inner-header">
				<h3>Welcome {{Auth::user()->name}}</h3>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="block no-padding">
		<div class="container">
			<div class="row no-gape">
				<aside class="col-lg-3 column border-right">
					<div class="widget">
						<div class="tree_widget-sec">
							<ul>
								<li><a href="{{ route('common.candidate-profile') }}" title=""><i class="la la-file-text"></i>My Profile</a></li>
								<li><a href="{{ route('common.applied_jobs_by_candidate') }}" title=""><i class="la la-paper-plane"></i>Applied Job</a></li>
								<li><a class="{{ Route::is('common.candidate.edit') ? 'active' : '' }}" href="{{ route('common.candidate.edit', Auth::user()->id) }}" title=""><i class="la la-file-text"></i>Update Profile</a></li>
							</ul>
						</div>
					</div>
				</aside>
				<div class="col-lg-9 column">
					@if (\Session::has('message'))
                    <div class="alert alert-info">
                        <ul>
                            <li class="text-center">{!! \Session::get('message') !!}</li>
                        </ul>
                    </div>
                    @endif
					<div class="padding-left">
						<div class="manage-jobs-sec">
							<h3>Manage Jobs</h3>
							<!-- <table id="applied_job_table" class="table table-bordered table-striped table-hover datatable"> -->
							<table>
								<thead>
									<tr>
										<td>Applied Job</td>
										<td>Job Location</td>
										<td>Applied Date</td>
										<td>Action</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
									@foreach($jobs as $job)
										<tr>
											<td>
												<div class="table-list-title">
													<i>{{$job->title}}</i><br />
													<!-- <span><i class="la la-map-marker">{{ App\Models\Location::where('id', $job->location_id)->pluck('name')->first() }}</i></span> -->
												</div>
											</td>
											<td>
												<div class="table-list-title">
													<h3><a href="#" title=""><i class="la la-map-marker">{{ App\Models\Location::where('id', $job->location_id)->pluck('name')->first() }}</i></a></h3>
												</div>
											</td>
											<td>
												<span>{{$job->applied_date}}</span><br />
											</td>
											@if($job->status=="1" && $job->deleted_at != true)
											<td>
											@if($job->job_expiry_date < date('Y-m-d'))
											<h6 class="text-danger">Expired</h6>
											@else
												<ul class="action_job">
													<li><span>View Job Details</span ><button class="btn btn-danger"><a href="{{ route('job_detail',$job->id) }}" title=""><i ></i>View Job</a></button></li>
												</ul>
											@endif
											</td>
											@else
											<td>
												<ul class="action_job">
													<li><span>Not Available</span><a href="#" title=""><i ></i>Not Available</a></li>
												</ul>
											</td>
											@endif
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')

@endsection