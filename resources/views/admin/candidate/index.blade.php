@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

<!-- table Links -->

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/paper/bootstrap.min.css" rel="stylesheet"> -->

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<link href="{{ asset('filter-each-column/Filter.css')}}" rel="stylesheet">

<!-- end tables links -->

<style>

.table tbody td:last-child{

    padding: 8px 14px;

}

.table tbody td:last-child a,

.table tbody td:last-child button{

    padding: 8px;

}

</style>   

@endsection

@section('content')

<div class="content-body">

    <div class="row">

        <div class="col-lg-12"> 

            <div class="card">

                <div class="card-header">

                    <h4 class="card-title">All Candidates</h4>

                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Candidate'))

                    <div class="heading-elements">

                        <div class="row">

                            <div class="col-lg-12">

                                <a class="btn btn-success" href="{{ route('common.candidate.create') }}">Add

                                    Candidate</a>

                            </div>

                        </div>

                    </div>

                    @endif

                </div>

                @if (session('message'))

                <div class="alert alert-icon-right alert-info alert-dismissible mb-2" role="alert">

                    <span class="alert-icon">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>

                    </span>

                    <strong>{!! session('message') !!}</strong>

                </div>

                @endif

                <div class="card-content collapse show">

                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">

                        <div class="table-responsive">

                            <div class="panel panel-primary filterable">

                                <div class="panel-heading">

                                <div class="container-fluid">

                                    <div class="row">

                                        @if(!Auth::user()->hasRole('Vendor'))

                                        <div class="col-lg-3 p-1">

                                            <form id="myForm" action="{{ route('common.filter_candidates') }}" method="post">

                                                @csrf

                                                <select class="form-control mr-1" style="width:50%;float:left" name="job_id" id="job_filter_value">

                                                    <option value="">Choose job for filter...</option>

                                                    @foreach($jobs as $key => $job)

                                                    <option value="{{$job->id}}" @if($job->id == $job_id)

                                                    selected @endif>{{$job->title}}</option>

                                                    @endforeach

                                                </select>

                                                <button type="button" onclick="filter()" class="btn btn-info mt-0">Filter By Job</button>

                                            </form>

                                        </div>

                                        @endif

                                        <div class="col-lg-4 p-1">

                                            <form action="{{ route('common.filter_by_exp') }}" method="post">
                                                @csrf
                                                <select class="form-control mr-1" style="width: 50%; float: left" name="exp">
                                                    <option value="">Choose Experience</option>
                                                    <option value="0-5" @if('0-5' == $exp) selected @endif>0-5</option>
                                                    <option value="5-10" @if('5-10' == $exp) selected @endif>5-10</option>
                                                    <option value="10-15" @if('10-15' == $exp) selected @endif>10-15</option>
                                                    <option value="15-20" @if('15-20' == $exp) selected @endif>15-20</option>
                                                    <option value="20-25" @if('20-25' == $exp) selected @endif>20-25</option>
                                                    <option value="25+" @if('25+' == $exp) selected @endif>25+</option>
                                                </select>
                                                <button type="submit" class="btn btn-info mt-0">Filter By Experience</button>
                                            </form>

                                        </div>

                                        <div class="col-lg-3 p-1">

                                            <form action="{{ route('common.filter_by_age') }}" method="post">

                                                @csrf

                                                <input type="number" name="age" value=" " min='0' style="width:150px" value="{{$age}}" placeholder="Enter Age here">

                                                <button type="submit" class="btn btn-info mt-0">Filter By Age</button>

                                                <a href="{{route('common.candidate.index')}}" class=" mt-0 btn btn-success "><span class="material-icons">cached</span></a>

                                            </form>

                                        </div>

                                        <div class="col-lg-1">

                                            <h3 class="panel-title @if(!Auth::user()->hasRole('Vendor')) text-right @endif mb-0">

                                                <button class="btn btn-default btn-xs btn-filter mt-1"><span class="glyphicon glyphicon-filter"></span>Click To Apply Filter</button>

                                            </h3>

                                        </div>

                                    </div>

                                    <p id="job_error" class="text-danger"></p>

                                    @if($errors->has('job_id'))

                                                   <p class="text-danger">{{ $errors->first('job_id') }}</p>

                                                @endif

                                                @if($errors->has('exp'))

                                                   <p class="text-danger">{{ $errors->first('exp') }}</p>

                                                @endif

                                                @if($errors->has('age'))

                                                   <p class="text-danger">{{ $errors->first('age') }}</p>

                                                @endif

                                    @if($users['candidate_detail'][0]->name == NULL && $VendorsCandidates['vendors_candidate_detail'][0] ==NULL)

                                    <h6 class="text-danger">No Result Found</h6>

                                    @endif

                                    </div>

                                </div>

                                <table class="table table-bordered table-striped">

                                    <thead>

                                        <tr class="filters">

                                            <th style="width:10px;"><input type="text" class="form-control"

                                                    placeholder="#" disabled></th>

                                            <th><input type="text" class="form-control" placeholder="Candidate"

                                                    disabled></th>

                                            <th><input type="text" class="form-control" placeholder="Email" disabled>

                                            </th>

                                            <th><input type="text" class="form-control" placeholder="Age" disabled>

                                            </th>

                                            <th style="padding: 16px 5px"><input type="text"  class="form-control" placeholder="Education"

                                                    disabled></th>

                                                    <th style="padding: 16px 7px"><input type="text" class="form-control" placeholder="Experience"

                                                    disabled></th>

                                            <th><input type="text" class="form-control" placeholder="Status" disabled>

                                            </th>

                                            <th style="width:160px;"><input type="text" class="form-control" placeholder="Action" disabled>

                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>



                                        @foreach($users['candidate_detail'] as $key => $candidate)

                                        <tr>

                                            <td>{{$key+1}}</td>

                                            <td>{{ $users['candidate_detail'][$key]->name }}</td>

                                            <td>{{$users['candidate_detail'][$key]->email }}</td>
                                            
                                            @if(!Auth::user()->hasRole('Vendor')) 

                                            <td>{{ \Carbon\Carbon::parse($users['profile'][$key]->dob)->age }}</td>

                                            @else

                                            <td>{{ \Carbon\Carbon::parse($users['candidate_detail'][$key]->dob)->age }}</td>

                                            @endif


                                            <td>@if($users['candidate_edu'][$key]['course'])
                                                @foreach(json_decode($users['candidate_edu'][$key]['course'],

                                                true) as $course){{ $course }}<br>

                                                @endforeach
                                                @endif
                                            </td>

                                                @php $totalDuration = 0; @endphp

                                                <td> @php
                                                    $startYears = isset($VendorsCandidates['vendors_candidate_exp'][$key]['start_year'])
                                                        ? json_decode($VendorsCandidates['vendors_candidate_exp'][$key]['start_year'], true)
                                                        : [];
                                                @endphp
                                                
                                                @foreach($startYears as $expkey => $start_year)

                                                @php

                                                $startTime = \Carbon\Carbon::parse($start_year);
                                                $endTime = date('Y-m-d');

                                                $endYears = $VendorsCandidates['vendors_candidate_exp'];

                                                if (isset($endYears[$key]['end_year'][$expkey])) {
                                                    $endYear = $endYears[$key]['end_year'][$expkey];


                                                    if(date('Y-m-d', strtotime($endYear)) == $endYear){
                                                        $endTime = \Carbon\Carbon::parse($endYear);
                                                    }
                                                    elseif ($endYear == "Present") {
                                                        $endTime = date('Y-m-d');
                                                    }

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                }

                                                    @endphp

                                                @endforeach
                                               
                                                {{round($totalDuration/12,1).' Year'}}

                                                </td>

                                            <td>@if($users['candidate_detail'][$key]->status =='1') Active @else

                                                Deactive @endif</td>

                                            <td>

                                                <a class="btn btn-xs btn-info" target="_blank"

                                                    href="{{ route('common.candidate.show',$users['candidate_detail'][$key]->id ) }}"><span class="material-icons">visibility</span></a>

                                                @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin') || (Auth::user()->hasRole('Vendor')))

                                                <a class="btn btn-xs btn-secondary"

                                                    href="{{ route('common.candidate.edit', $users['candidate_detail'][$key]->id ) }}"><span

                                                        class="material-icons">create</span></a>

                                                @endif

                                                @if(Auth::user()->hasRole('Super Admin') ||Auth::user()->hasRole('Admin') || (Auth::user()->hasRole('Vendor')))

                                                <form action="{{ route('common.candidate.destroy', $users['candidate_detail'][$key]->id ) }}"

                                                    method="POST"

                                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"

                                                    style="display: inline-block;">

                                                    <input type="hidden" name="_method" value="DELETE">

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                    <button type="submit" class="btn btn-xs btn-danger"><span

                                                            class="material-icons">delete</span></button>

                                                </form>

                                                @endif

                                            </td>

                                        </tr>

                                        @endforeach

                                        

                                        @if(isset($VendorsCandidates['vendors_candidate_detail']) && !empty($VendorsCandidates['vendors_candidate_detail'][0]->id))

                                            @if(!Auth::user()->hasRole('Vendor'))

                                             <tr><th colspan="9" class="text-center">Vendors Candidates</th></tr>

                                             @endif

                                            @endif

                                            @if(isset($VendorsCandidates['vendors_candidate_detail']))
                                            @foreach($VendorsCandidates['vendors_candidate_detail'] as $key => $applied_job)

                                            <tr>

                                                <td>{{$key+1}}</td>

                                               

                                                <td><a class="" target="_blank"

                                                        href="{{ route('common.vendors_candidates_show', $VendorsCandidates['vendors_candidate_detail'][$key]->id) }}">{{ $VendorsCandidates['vendors_candidate_detail'][$key]->name }}</a>

                                                </td>

                                                <td>{{$VendorsCandidates['vendors_candidate_detail'][$key]->email  }}</td>

                                                <td>{{ \Carbon\Carbon::parse($VendorsCandidates['vendors_candidate_detail'][$key]->dob)->age}}</td>

                                             
                                                @if (isset($VendorsCandidates['vendors_candidate_edu'][$key]))
                                                <td>
                                                    @php
                                                    $courses = json_decode($VendorsCandidates['vendors_candidate_edu'][$key]['course'], true) ?? [];
                                                    if (is_array($courses)) {
                                                        foreach ($courses as $course) {
                                                            echo $course . "<br>";
                                                        }
                                                    }
                                                    @endphp
                                                </td>
                                            
                                                @php
                                                $totalDuration = 0;
                                                @endphp
                                            @else
                                                <td></td>
                                            @endif
                                            @php
                                            $startYears = isset($VendorsCandidates['vendors_candidate_exp'][$key]['start_year'])
                                                ? json_decode($VendorsCandidates['vendors_candidate_exp'][$key]['start_year'], true)
                                                : [];
                                        @endphp
                                        
                                        @foreach($startYears as $expkey => $start_year)
                                              
                                                    @php

                                                $startTime = \Carbon\Carbon::parse($start_year);
                                                $endTime = date('Y-m-d');

                                                $endYears = $VendorsCandidates['vendors_candidate_exp'];

                                                if (isset($endYears[$key]['end_year'][$expkey])) {
                                                    $endYear = $endYears[$key]['end_year'][$expkey];


                                                    if(date('Y-m-d', strtotime($endYear)) == $endYear){
                                                        $endTime = \Carbon\Carbon::parse($endYear);
                                                    }
                                                    elseif ($endYear == "Present") {
                                                        $endTime = date('Y-m-d');
                                                    }

                                                    $totalDuration += $startTime->diffInMonths($endTime);
                                                }

                                                    @endphp

                                                    

                                                @endforeach

                                                {{round($totalDuration/12,1).' Year'}}



                                                </td>

                                                <td>@if($VendorsCandidates['vendors_candidate_detail'][$key]->status =='1') Active @else

                                                Deactive @endif</td>

                                            <td>

                                                <a class="btn btn-xs btn-info" target="_blank"

                                                    href="{{ route('common.vendors_candidates_show',$VendorsCandidates['vendors_candidate_detail'][$key]->id ) }}"><span class="material-icons">visibility</span></a>

                                                @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin') || (Auth::user()->hasRole('Vendor')))

                                                <a class="btn btn-xs btn-secondary"

                                                    href="{{ route('common.candidateEdit', $VendorsCandidates['vendors_candidate_detail'][$key]->id ) }}"><span

                                                        class="material-icons">create</span></a>

                                                @endif

                                                @if(Auth::user()->hasRole('Super Admin') ||Auth::user()->hasRole('Admin') || (Auth::user()->hasRole('Vendor')))

                                                <form action="{{ route('common.candidateDestroy', $VendorsCandidates['vendors_candidate_detail'][$key]->id ) }}"

                                                    method="POST"

                                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"

                                                    style="display: inline-block;">

                                                    <input type="hidden" name="_method" value="DELETE">

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                    <button type="submit" class="btn btn-xs btn-danger"><span

                                                            class="material-icons">delete</span></button>

                                                </form>

                                                @endif

                                            </td>

                        

                                            </tr>

                                          

                                            @endforeach
                                            @endif

                                            

                                    </tbody>

                                </table>

                            </div>

                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>

<!--     <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>

<script src="{{ asset('app-assets/vendors/js/tables/buttons.flash.min.js') }}"></script>

<script src="{{ asset('app-assets/vendors/js/tables/jszip.min.js') }}"></script>

<script src="{{ asset('app-assets/vendors/js/tables/pdfmake.min.js') }}"></script>

<script src="{{ asset('app-assets/vendors/js/tables/vfs_fonts.js') }}"></script>

<script src="{{ asset('app-assets/vendors/js/tables/buttons.html5.min.js') }}"></script>

<script src="{{ asset('app-assets/vendors/js/tables/buttons.print.min.js') }}"></script> -->

<script src="{{ asset('app-assets/js/scripts/pages/material-app.min.js') }}"></script>

<script src="{{ asset('app-assets/js/scripts/tables/datatables/datatable-advanced.min.js') }}"></script>



<!-- table js -->

<script src="{{ asset('filter-each-column/Filter.js')}}"></script>

<script>

    try {

        fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", {

            method: 'HEAD',

            mode: 'no-cors'

        })).then(function (response) {

            return true;

        }).catch(function (e) {

            var carbonScript = document.createElement("script");

            carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";

            carbonScript.id = "_carbonads_js";

            document.getElementById("carbon-block").appendChild(carbonScript);

        });

    } catch (error) {

        console.log(error);

    }



</script>

<script>

function filter(){

 var abc =  document.getElementById("job_filter_value");

var b=abc.value;

console.log(b);

if(b!=''){

document.getElementById("myForm").submit();  

}

else{

    document.getElementById("job_error").innerHTML = "Please select a Job First";

}

}

</script>

<script type="text/javascript">

    var _gaq = _gaq || [];

    _gaq.push(['_setAccount', 'UA-36251023-1']);

    _gaq.push(['_setDomainName', 'jqueryscript.net']);

    _gaq.push(['_trackPageview']);



    (function () {

        var ga = document.createElement('script');

        ga.type = 'text/javascript';

        ga.async = true;

        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +

            '.google-analytics.com/ga.js';

        var s = document.getElementsByTagName('script')[0];

        s.parentNode.insertBefore(ga, s);

    })();



</script>

<!-- end table js -->

@endsection

