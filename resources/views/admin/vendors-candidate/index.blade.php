@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
<!-- table Links -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/paper/bootstrap.min.css" rel="stylesheet"> -->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="{{ asset('filter-each-column/Filter.css')}}" rel="stylesheet">
<!-- end tables links -->
<style  nonce="{{ csp_nonce() }}">
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
                    @if(Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Admin') || (Auth::user()->hasRole('Vendor')))
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
                                        <div class="col-lg-8 p-1">
                                            <form action="{{ route('common.filter_candidates') }}" method="post">
                                                @csrf
                                                <select class="form-control mr-1" style="width:50%;float:left" name="job_id">
                                                    <option value="">Choose job for filter...</option>
                                                    @foreach($jobs as $key => $job)
                                                    <option value="{{$job->id}}" @if($job->id == $job_id)
                                                    selected @endif>{{$job->title}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-info mt-0">Filter By Job</button>
                                                <a href="{{route('common.candidate.index')}}" class=" mt-0 btn btn-success "><span class="material-icons">cached</span></a>
                                            </form>
                                        </div>
                                        @endif
                                        <div class="col-lg-4">
                                            <h3 class="panel-title @if(!Auth::user()->hasRole('Vendor')) text-right @endif mb-0">
                                                <button class="btn btn-default btn-xs btn-filter mt-1"><span class="glyphicon glyphicon-filter"></span>Click To Apply Filter</button>
                                            </h3>
                                        </div>
                                    </div>
                                    @if($users['candidate_detail'][0]->name == NULL)
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
                                            <td>@foreach(json_decode($users['candidate_edu'][$key]['course'],
                                                true) as $course){{ $course }}<br>
                                                @endforeach
                                            </td>
                                                @php $totalDuration = 0; @endphp
                                                <td>@foreach(json_decode($users['candidate_exp'][$key]['start_year'], true) as $expkey => $start_year)
                                                    @php
                                                    $startTime = \Carbon\Carbon::parse($start_year);

                                                    $endTime = \Carbon\Carbon::parse(json_decode($users['candidate_exp'][$key]['end_year'], true)[$expkey]);

                                                    $totalDuration += $startTime->diffInYears($endTime);
                                                    @endphp
                                                @endforeach

                                                {{$totalDuration.'Year'}}

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
