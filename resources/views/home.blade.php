@extends('layouts.web')
@section('content')
<section>
    <div class="block no-padding">
        <div class="container fluid">
            <div class="main-featured-sec">
                <div class="new-slide-3">
                    <img src="{{ asset('images/construction-jgc.jpg') }}">
                </div>
                <div class="job-search-sec">
                    <div class="job-search">
                        <h3>Delivering Life Cycle Values to Industries</h3>
                        <span>Find Jobs, Employment & Career Opportunities</span>
                        <form action="{{route('search-location')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="job-field">
                                        <select name="location" data-placeholder="City, province or region"
                                            class="chosen-city">
                                            <option value="">Choose Location</option>
                                            @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }} </option>
                                            @endforeach
                                        </select>
                                        <i class="la la-map-marker"></i>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
                                    <button type="submit"><i class="la la-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="scroll-to">
                    <a href="#scroll-here" title=""><i class="la la-arrow-down"></i></a>
                </div>
            </div>
        </div>
        @if(\Session::has('message'))
        <div class="alert alert-info">
            <ul>
                <li class="text-center text-success">{!! \Session::get('message') !!}</li>
            </ul>
        </div>
        @endif
    </div>
</section>
<section>
    <div class="block">
        <div data-velocity="-.1"
            style="background: url(front/images/parallax5.jpg) repeat scroll 50% 422.28px transparent;"
            class="parallax scrolly-invisible no-parallax"></div>
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 column">
                    <form action="{{ route('filter-home-job') }}" method="post">
                        @csrf
                        <div class="widget border">
                            <h3 class="sb-title closed">Job Type</h3>
                            <div class="type_widget">
                                @foreach($jobtypes as $jobtype)
                                <p class="flchek">
                                    <input value="{{ $jobtype->id }}" type="radio" name="job_type"
                                        id="{{ $jobtype->job_type.$jobtype->id }}"
                                        @if(\Request::get("job_type")==" $jobtype->id" ) checked @endif>
                                    <label for="{{ $jobtype->job_type.$jobtype->id }}">{{ $jobtype->job_type }}</label>
                                </p>
                                @endforeach
                            </div>
                        </div>
                        <div class="widget border">
                            <h3 class="sb-title closed">Experience</h3>
                            <div class="specialism_widget">
                                <div class="simple-checkbox">
                                    <p><span>
                                        <label>From Year</label>
                                        <input type="number" name="experienceFrom" min="0" max="20"
                                            style="width:50%" value="0">
                                        <label>To Year     </label>
                                        <input type="number" name="experienceTo" min="0" max="20"
                                            style="width:50%; margin-top:5px" value="3">
                                            </span>
                                    </p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="widget border">
                            <h3 class="sb-title closed">Qualification</h3>
                            <div class="specialism_widget">
                                <div class="type_widget">
                                    <p>
                                        <input type="checkbox" value="Graduate" name="qualification" id="qualification1"
                                            @if(\Request::get("qualification")=='Graduate' ) checked @endif>
                                        <label for="qualification1">Graduate</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" value="Post Graduate" name="qualification"
                                            id="qualification2" @if(\Request::get("qualification")=='Post Graduate' )
                                            checked @endif>
                                        <label for="qualification2">Post Graduate</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" value="Diploma" name="qualification" id="qualification3"
                                            @if(\Request::get("qualification")=='Diploma' ) checked @endif>
                                        <label for="qualification3">Diploma</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" value="Doctorate" name="qualification"
                                            id="qualification4" @if(\Request::get("qualification")=='Doctorate' )
                                            checked @endif>
                                        <label for="qualification4">Doctorate</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="widget border">
                            <h3 class="sb-title closed">Category</h3>
                            <div class="specialism_widget">
                                <div class="type_widget">
                                    @foreach($departments as $department)
                                    <p class="flchek">
                                        <input value="{{ $department->id }}" type="radio" name="department"
                                            id="{{ $department->id }}"
                                            @if(\Request::get("department")==" $department->id" ) checked @endif>
                                        <label for="{{ $department->id }}">{{ $department->name }}</label>
                                    </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control filter-button">Filter Jobs</button>
                        </div>
                    </form>
                </aside>
                <div class="col-lg-9">
                    @if(isset($recent_jobs[0]['title']))
                    <div class="heading">
                        <h2> Search Result</h2>
                    </div>
                    @else
                    <div class="heading">
                        <h2>Featured Jobs</h2>
                    </div>
                    @endif

                    <div class="job-listings-sec">
                        @if(empty($jobs[0]['title']))
                        <h5 class="text-danger text-center p-3">No result found</h5>
                        <h2 class="p-3">Other Jobs</h2>
                        @foreach($recent_jobs as $job)
                        <div class="job-listing rounded">
                            <div class="job-title-sec">
                                @if($job->attachment !=NULL)
                                <div class="c-logo">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($job->attachment) }}"
                                        alt="{{ $job->attachment }}">
                                </div>
                                @else
                                <div class="c-logo">
                                    <img src="{{ asset('images/default_job.svg') }}" alt="{{ $job->attachment }}">
                                </div>
                                @endif
                                <input type="hidden" name="hidden" value="{{$job->id}}">
                                <h3><a href="{{ route('job_detail',$job->id) }}" title="">{{$job->title}}</a></h3>
                                <span>{{ $job->departments->name }}</span>
                            </div>
                            <span class="job-lctn"><i
                                    class="la la-map-marker"></i>{{ $job->locations->name ?? '' }}</span>
                            <!-- <span class="fav-job"><i class="la la-heart-o"></i></span> -->
                            <span class="job-is ft">{{$job->job_type->job_type}}</span>
                        </div>
                        @endforeach
                        @endif
                        @foreach($jobs as $job)
                        <div class="job-listing rounded">
                            <div class="job-title-sec">
                                @if($job->attachment !=NULL)
                                <div class="c-logo">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($job->attachment) }}"
                                        alt="{{ $job->attachment }}">
                                </div>
                                @else
                                <div class="c-logo">
                                    <img src="{{ asset('images/default_job.svg') }}" alt="{{ $job->attachment }}">
                                </div>
                                @endif
                                <input type="hidden" name="hidden" value="{{$job->id}}">
                                <h3><a href="{{ route('job_detail',$job->id) }}" title="">{{$job->title}}</a></h3>
                                <span>{{ $job->departments->name }}</span>
                            </div>
                            <span class="job-lctn"><i
                                    class="la la-map-marker"></i>{{ $job->locations->name ?? '' }}</span>
                            <!-- <span class="fav-job"><i class="la la-heart-o"></i></span> -->
                            <span class="job-is ft">{{$job->job_type->job_type}}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="browse-all-cat red">
                        <a href="{{ route('browse-jobs') }}" title="">View More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="block gray">
        <div data-velocity="-.1"
            style="background: url(front/images/mslider2.jpg) repeat scroll 50% 422.28px transparent;"
            class="parallax scrolly-invisible layer color red"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        <div class="row">
                            <div class="col-4">
                                <div class="quick-select">
                                    <a href="https://jgc.com.sa/services#engineering" target="_blank" title="">
                                        <i class="la la-bullhorn"></i>
                                        <span>Engineering</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="quick-select">
                                    <a href="https://jgc.com.sa/services#procurement" target="_blank" title="">
                                        <i class="la la-graduation-cap"></i>
                                        <span>Procurement</span>
                                        <!-- <p>(06 open positions)</p> -->
                                    </a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="quick-select">
                                    <a href="https://jgc.com.sa/services#constructionManagement" target="_blank"
                                        title="">
                                        <i class="la la-line-chart "></i>
                                        <span>Construction Management</span>
                                        <!-- <p>(03 open positions)</p> -->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading">
                        <h2>How It Works</h2>
                        <span>Register and stay updated with latest career opportunity with JGC GULF</span>
                    </div>
                    <div class="how-to-sec">
                        <div class="how-to">
                            <span class="how-icon"><i class="la la-user"></i></span>
                            <h3>Register an account</h3>
                        </div>
                        <div class="how-to">
                            <span class="how-icon"><i class="la la-file-archive-o"></i></span>
                            <h3>Specify & search your job</h3>
                        </div>
                        <div class="how-to">
                            <span class="how-icon"><i class="la la-list"></i></span>
                            <h3>Apply for job</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="social-links">
                        <a href="https://www.facebook.com/JGC-Gulf-International-Co-Ltd-128484563876968" target="_blank"
                            title="" class="fb-color"><i class="fa fa-facebook"></i> Facebook</a>
                        <a href="https://www.linkedin.com/company/jgc-gulf-international-ltd--/" target="_blank"
                            title="" class="tw-color"><i class="fa fa-linkedin"></i> Linkedin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $(".rounded").on("click", function (e) {
            e.preventDefault();
            var id = $(this).find(':hidden').val();
            window.location.href = "job_detail/" + id;
        });
    });

</script>
@endsection
