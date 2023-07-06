@extends('layouts.web')
@section('styles')
<style type="text/css">
    .job-overview {
        border: unset !important;
    }

    .job-overview ul {
        padding: 0px !important;
    }

    .tree_widget-sec ul li.active {
        color: #8b91dd;
    }

</style>
@endsection
@section('content')
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1"
            style="background: url('{{ asset('front/images/mslider1.jpg') }}') repeat scroll 50% 422.28px transparent;"
            class="parallax scrolly-invisible no-parallax"></div>
        <div class="container fluid">
            <div class="inner-header">
                <h3>Welcome {{ Auth::user()->name }}</h3>
            </div>
        </div>
    </div>
</section>
@if (\Session::has('message'))
<div class="alert alert-info ">
    <ul>
        <li class="text-center text-success">{!! \Session::get('message') !!}</li>
    </ul>
</div>
@endif
<section>
    <div class="block remove-top">
        <div class="container">
            <div class="row no-gape">
                <aside class="col-lg-3 column border-right">
                    <div class="widget">
                        <div class="tree_widget-sec">
                            <ul>
                                <li><a class="{{ Route::is('common.candidate-profile') ? 'active' : '' }}"
                                        href="{{ route('common.candidate-profile') }}" title=""><i
                                            class="la la-file-text"></i>My Profile</a></li>
                                <li><a class="{{ Route::is('common.candidate.edit') ? 'active' : '' }}"
                                        href="{{ route('common.candidate.edit', Auth::user()->id) }}" title=""><i
                                            class="la la-file-text"></i>Update Profile</a></li>
                                <li><a class="{{ Route::is('common.applied_jobs_by_candidate') ? 'active' : '' }}"
                                        href="{{ route('common.applied_jobs_by_candidate') }}" title=""><i
                                            class="la la-paper-plane"></i>Applied Job</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="skill-perc">
                            <h6>Profile Completion Percentage</h6>
                            <!-- <p>Put value for "Cover Image" field to increase your skill up to "15%"</p> -->
                            <div class="skills-bar">
                                <span>{{ $profilePercentage }}%</span>
                                <div class="second circle" data-size="200" data-thickness="60"></div>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="col-lg-9 column">
                    <div class="padding-left">
                        <div class="manage-jobs-sec">
                            <div class="border-title">
                                <h3>Personal Info</h3>
                            </div>
                            <div class="edu-history-sec">
                                <div class="job-overview style2">
                                    <ul>
                                        <li><i class="la la-home"></i>
                                            <h3>Address</h3><span>{{ $profile->address }}</span>
                                        </li>
                                        <li><i class="la la-map-marker"></i>
                                            <h3>City</h3><span>{{ $profile->city }}</span>
                                        </li>
                                        <li><i class="la la-map"></i>
                                            <h3>State</h3><span>{{ $profile->state }}</span>
                                        </li>
                                        <li><i class="la la-map"></i>
                                            <h3>Country</h3><span>{{ $profile->country }}</span>
                                        </li>
                                        <li><i class="la la-map-pin"></i>
                                            <h3>Pincode</h3><span>{{ $profile->zip_code }}</span>
                                        </li>
                                        <!-- <li><i class="la la-mars-double"></i>
                                            <h3>Gender</h3><span>{{ $profile->gender }}</span>
                                        </li> -->
                                        <li><i class="la la-birthday-cake"></i>
                                            <h3>Date of Birth</h3>
                                            <span>{{ Carbon\Carbon::parse($profile->dob)->format('d-M-Y')   }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            @php
                            if ($educations !== null) {
                                $levels = json_decode($educations->level, true);
                            } else {
                                $levels = [];
                            }
                            @endphp
                            
                            @if($levels !== null)
                            <div class="border-title">
                                <h3>Education </h3>
                                <!-- <a href="#" title=""><i class="la la-plus"></i> Add Education</a> -->
                            </div>
                            <div class="edu-history-sec">
                                @foreach($levels as $key => $level)
                                <div class="edu-history">
                                    <i class="la la-graduation-cap"></i>
                                    <div class="edu-hisinfo">
                                        <h3>{{ $level }}</h3>
                                        @php $course = json_decode($educations->course, true); @endphp
                                        @php $start_year = json_decode($educations->start_year, true); @endphp
                                        @php $end_year = json_decode($educations->end_year, true); @endphp
                                        @php $university = json_decode($educations->university, true); @endphp
                                        @php $percentage = json_decode($educations->percentage, true); @endphp
                                        <i>{{ $start_year[$key] }} - {{ $end_year[$key] }}</i>
                                        <span>{{ $university[$key] }} <i>{{ $course[$key] }}</i></span>
                                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p> -->
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @php $levels = json_decode($experiences->level, true); @endphp
                            @if($levels !== null)
                            <div class="border-title">
                                <h3>Work Experience</h3>
                            </div>
                            <div class="edu-history-sec">
                                @foreach($levels as $key => $level)
                                @if($level == 'Fresher' )
                              
                                    <h6 class="text-danger">Fresher</h6>
                                   
                                @else                                
                                <div class="edu-history style2">
                                    <i></i>
                                    <div class="edu-hisinfo">
                                    
                                        @php $designation = json_decode($experiences->designation, true); @endphp
                                        @php $organisation = json_decode($experiences->organisation, true); @endphp
                                        @php $start_year = json_decode($experiences->start_year, true); @endphp
                                        @php $end_year = json_decode($experiences->end_year, true); @endphp
                                        @php $department = json_decode($experiences->department, true); @endphp
                                        <h3>{{ $designation[$key] }} <span>{{ $organisation[$key] }}</span></h3>
                                        <i>{{ $start_year[$key] }} - {{ $end_year[$key] }}</i>
                                        <i>{{ $department[$key] }}</i>
                                        <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p> -->
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
							<div class="border-title">
                                <h3>About You</h3>
                            </div>
                            <div class="edu-history-sec">
                                <div class="job-overview style2">
                                    <p>{!! $profile->about !!}</p>
                                </div>
                            </div>
							<div class="border-title">
                                <h3>Resume</h3>
                            </div>
                            <div class="edu-history-sec">
                                <div class="job-overview style2">
						
								
								
									@php
									$ext = pathinfo(Illuminate\Support\Facades\Storage::url('resume/'. Auth::user()->id.'/'.Auth::user()->profile->resume), PATHINFO_EXTENSION);
									@endphp
									@if ($ext =='docx' || $ext=='doc')
									<a class="" style="width:15%" href="{{\Illuminate\Support\Facades\Storage::url('resume/'. Auth::user()->id.'/'.Auth::user()->profile->resume)}}" download>Download Resume</a>
									@else
									<embed src="{{ \Illuminate\Support\Facades\Storage::url('resume/'. Auth::user()->id .'/'. Auth::user()->profile->resume) }}" type="application/pdf"   height="700px" width="100%">
									@endif

                                </div>
                            </div>
                            @endif
                            <a class="btn btn-danger" href="{{ route('common.candidate.edit', Auth::user()->id) }}">Edit
                                Your Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('front/js/circle-progress.min.js') }}"></script>
<script>
    (function ($) {
        $('.second.circle').circleProgress({
            startAngle: -Math.PI / 8 * 0,
            value: "{{ $profilePercentage }}"/100,
            emptyFill: 'rgba(0, 0, 0, 0)',
            fill: {
                gradient: ['#fa3979', '#e22d68']
            }
        }).on('circle-animation-progress', function (event, progress) {
            $(this).find('strong').html(Math.round(100 * progress) + '<i>%</i>');
        });
    })(jQuery);

</script>
@endsection
