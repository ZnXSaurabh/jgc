@extends('layouts.web')
@section('content')
<section class="overlape">
	<div class="block no-padding">
		<div data-velocity="-.1" style="background: url(<?php asset('front/images/mslider1.jpg'); ?>) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
		<div class="container fluid">
			<div class="inner-header">
				<h3>{{$job->title}}</h3>
				<h5 class="text-center" style="color:white">{{$job->job_id}}</h5>
			</div>
		</div>
	</div>
</section>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close_model" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Thankyou for applying this job </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger close_model" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<section>
	<div class="block">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 column">
					<div class="job-single-sec style3">
						<div class="job-head-wide">
							<div class="row">
								<div class="col-lg-8">
									<div class="job-single-head3">
										<div class="job-single-info3">
											<h3>{{ $job->organisation }}</h3>
											@if($job->attachment !=NULL)
											<div class="c-logo"><img src="{{ \Illuminate\Support\Facades\Storage::url($job->attachment) }}" alt="" /></div>
											@else
											<div class="c-logo"><img src="{{ asset('images/default_job.svg') }}"/></div>
											@endif
											
											<span><i class="la la-map-marker"></i>{{ $job->locations->name ?? '' }}</span><span class="job-is ft">{{ $job->job_type->job_type ?? '' }}</span>
											<ul class="tags-jobs">
												<li><i class="la la-calendar-o"></i> Post Date: {{ Carbon\Carbon::parse($job->posting_date)->format('d-M-Y')   }}</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
								@if(isset($applied_job->job_id) && isset(Auth::user()->id))
									@if($job->id==$applied_job->job_id && $applied_job->candidate_id==Auth::user()->id)
									<h4 style="color:green">Applied</h4>
									@endif
								@else
									@if(Auth::user())
										@if(Auth::user()->hasRole('Vendor') || Auth::user()->hasRole('Candidate'))
											<a href=""   data-toggle="modal" data-target="#myModal" data-backdrop="static" class="apply-thisjob apply_btn" ><i class="la la-paper-plane"></i>Apply for job</a>
											<input type="hidden" class="apllied_job_id" value="{{$job->id}}">
										@endif
									@endif
									@if(!Auth::user())
									<a href="#" class="apply-thisjob signup-popup"><i class="la la-paper-plane"></i>Apply for job</a>
									@endif
								@endif
								</div>
							</div>
						</div>
						<div class="job-wide-devider">
							<div class="row">
								<div class="col-lg-8 column">
									<div class="job-details">
									<h3 class="text-center text-danger">Job Description</h3>
									<div class="description-div">
										{!!$job->description!!}
									</div>
									</div>
									<div class="share-bar">
										<span>Share</span><a href="https://www.facebook.com/JGC-Gulf-International-Co-Ltd-128484563876968" target="_blank" title="" class="share-fb"><i class="fa fa-facebook"></i></a><a href="https://www.linkedin.com/company/jgc-gulf-international-ltd--/" target="_blank" title="" class="share-twitter"><i class="fa fa-linkedin"></i></a>
									</div>
									@if($similar_jobs != NULL)
									<div class="recent-jobs">
										<h2 class="text-center text-danger">Similar Jobs</h2>
										<div class="job-list-modern">
											<div class="job-listings-sec no-border">
												@foreach($similar_jobs as $similar_job)
												<div class="job-listing wtabs">
													<div class="job-title-sec">
														@if($similar_job->attachment !=NULL)
						                                <div class="c-logo">
						                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($similar_job->attachment) }}" alt="{{ $similar_job->attachment }}">
						                                </div>
						                                @else
						                                <div class="c-logo">
						                                    <img src="{{ asset('images/default_job.svg') }}" alt="">
						                                </div>
						                                @endif
														<input type="hidden" name="hidden" value="{{ $similar_job->id }}">
														<h3><a href="{{ route('job_detail', $similar_job->id) }}" title="">{{ $similar_job->title }}</a></h3>
														<div class="job-lctn"><i class="la la-map-marker"></i>{{ $job->locations->name }}</div>
													</div>
													<div class="job-style-bx">
														<span class="job-is ft">{{ $job->job_type->job_type }}</span>
													</div>
												</div>
												@endforeach
											</div>
										</div>
									</div>
									@endif
								</div>
								<div class="col-lg-4 column">
									<div class="job-overview">
										<h3>Job Overview</h3>
										<ul>
											<li><i class="la la-users"></i><h3>No. Of Vacancy </h3><span>{{$job->no_of_vacancy}}</span></li>
											<li><i class="la la-mars-double"></i><h3>Gender Preference</h3><span>{{$job->gender_preference}}</span></li>
											<li><i class="la la-map-marker"></i><h3>Location Preference</h3><span>{{$job->location_preference}}</span></li>
											<li><i class="la la-shield"></i><h3>Experience</h3><span>{{$job->minimum_exp_req}}</span></li>
											<li><i class="la la-line-chart "></i><h3>Qualification</h3><span>{{ $job->minimum_qualification }}</span></li>
											@if($job->job_expiry_date != NULL)
												<li><i class="la la-calendar-o"></i><h3>Job Expiry Date</h3><span> {{ Carbon\Carbon::parse($job->job_expiry_date)->format('d-M-Y')   }}</span></li>
											@endif
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
		
        $(".wtabs").on("click", function(e) {
            e.preventDefault();
             var id = $(this).find(':hidden').val();
             window.location.href="/job_detail/"+id;
        });
    });
	$('.close_model').click(function(){
		location.reload();
	});

			$('.apply_btn').click(function(){
				var job_id = $('.apllied_job_id').val();
				$.ajax({
					type: 'GET',
					url: "{{ route('applied_job',$job->id) }}",
					data: { id: job_id },
				});
			});
</script>
@endsection