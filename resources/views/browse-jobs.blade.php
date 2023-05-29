@extends('layouts.web')
@section('content')
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url(front/images/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <div class="container fluid">
            <div class="inner-header wform">
                <div class="job-search-sec">
                    <div class="job-search">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="text-white text-center">Explore Jobs With Just Simple Search...</h4>
                                <form action="{{ route('search-location-browse') }}" method="post">
                                    @csrf
                                    <div class="row">
                                    <div class="col-2"></div>
                                        <div class="col-6">
                                            <div class="job-field">
                                                <select name="location" data-placeholder="City, province or region" class="chosen-city">
                                                    <option value="">Choose Location</option>
                                                    @foreach($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name ?? ''}} </option>
                                                    @endforeach
                                                </select>
                                                <i class="la la-map-marker"></i>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="submit"><i class="la la-search"></i></button>
                                        </div>
                                        <div class="col-2"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="block remove-top">
        <div class="container">
            <div class="row no-gape">
                <aside class="col-lg-3 column">
                    <form action="{{  route('filter-job') }}" method="post">
                        @csrf
                        <div class="widget border">
                            <h3 class="sb-title closed">Job Type</h3>
                            <div class="type_widget">
                                @foreach($jobtypes as $jobtype)
                                <p class="flchek">
                                    <input value="{{ $jobtype->id ?? '' }}" type="radio"  name="job_type" id="{{ $jobtype->job_type.$jobtype->id }}" @if(\Request::get("job_type") == " $jobtype->id") checked  @endif>
                                    <label for="{{ $jobtype->job_type.$jobtype->id }}">{{ $jobtype->job_type ?? '' }}</label>
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
                                <div class="simple-checkbox">
                                    <p>
                                        <input type="checkbox" value="Graduate" @if(\Request::get("qualification") == 'Graduate') checked  @endif  id="Graduate" name="qualification">
                                        <label for="Graduate">Graduate</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" value="Post Graduate" @if(\Request::get("qualification") == 'Post Graduate') checked  @endif id="Post Graduate"  name="qualification">
                                        <label for="Post Graduate">Post Graduate</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" value="Diploma" @if(\Request::get("qualification") == 'Diploma') checked  @endif id="Diploma" name="qualification">
                                        <label for="Diploma">Diploma</label>
                                    </p>
                                    <p>
                                        <input type="checkbox" value="Doctorate" @if(\Request::get("qualification") == 'Doctorate') checked  @endif id="Doctorate" name="qualification">
                                        <label for="Doctorate">Doctorate</label>
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
                                    <input value="{{ $department->id }}" type="radio" name="department" id="{{ $department->id }}" @if(\Request::get("department") == " $department->id") checked  @endif>
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
                <div class="col-lg-9 column">
                    <div class="job-list-modern">
                        <div class="job-listings-sec no-border">
                            @if(isset($recent_jobs[0]['title']))
                            <div class="heading p-3"><h2> Search Result</h2></div>
                            @else
                            <div class="heading p-3">
                        <h2>Featured Jobs</h2>
                    </div>
                            @endif
                            @if(empty($jobs[0]['title']))
                            <h5 class="text-danger text-center p-5">No result found</h5>
                            <h2 class="p-3">Other Jobs</h2>
                            @foreach($recent_jobs as $job)
                        <div class="job-listing rounded">
                            <div class="job-title-sec">
                                @if($job->attachment !=NULL)
                                <div class="c-logo">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($job->attachment) }}" alt="{{ $job->attachment }}">
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
                            <span class="job-lctn"><i class="la la-map-marker"></i>{{ $job->locations->name ?? '' }}</span>
                            <!-- <span class="fav-job"><i class="la la-heart-o"></i></span> -->
                            <span class="job-is ft">{{$job->job_type->job_type}}</span>
                        </div>
                        @endforeach
                            @endif
                            @foreach($jobs as $job)
                            <div class="job-listing wtabs">
                                <div class="job-title-sec">
                                    @if($job->attachment !=NULL)
                                    <div class="c-logo">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($job->attachment) }}" alt="{{ $job->attachment }}">
                                    </div>
                                    @else
                                    <div class="c-logo">
                                        <img src="{{ asset('images/default_job.svg') }}" alt="">
                                    </div>
                                    @endif
                                    <input type="hidden" name="hidden" value="{{$job->id}}">
                                    <h3><a href="{{  route('job_detail',$job->id)  }}" title="">{{ $job->title ?? '' }}</a></h3>
                                    <span>{{ $job->departments->name }}</span>
                                </div>
                                <span class="job-lctn"><i class="la la-map-marker"></i>{{ $job->locations->name ?? '' }}</span>
                                <div class="job-style-bx"><span class="job-is ft">{{ $job->job_type->job_type ?? '' }}</span></div>
                            </div>
                            @endforeach
                        </div>
                        <div class="pagination"><ul>{{ $jobs->links() }}</ul></div>
                        
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
$(".wtabs").on("click", function (e) {
e.preventDefault();
var id = $(this).find(':hidden').val();
window.location.href = "job_detail/" + id;
});
});
</script>
@endsection