@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

<!-- table Links -->

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.4.0/paper/bootstrap.min.css" rel="stylesheet"> -->

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<link href="{{ asset('filter-each-column/Filter.css')}}" rel="stylesheet">

<!-- end tables links -->

<style  nonce="{{ csp_nonce() }}">

    .table tr td{

        padding:3px;

        font-size:10px;

    }

    .table td:first-child, .table th:first-child {

    padding-left: 5px!important;

    text-align:center;

    }

    .table th{

        padding:0.75rem 1rem;

    }

</style>

@endsection

@section('content')

<div class="content-body">

    <div class="row">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-header">

                    <h4 class="card-title">All KFUPM User</h4>

                </div>

                @if (session('message'))

                <div class="alert alert-icon-right alert-info alert-dismissible mb-2" role="alert">

                    <span class="alert-icon">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>

                    </span>

                    <strong>{!! session('message') !!}</strong>

                </div>

                @endif

                <div class="col-lg-3 float-right">

                <a href="{{ route('common.kfupm_user-export')}}" class="btn btn-warning download-btn"> 

        

                    <i data-feather="plus-circle"></i>

        

                    Download Excel

        

                </a>

                </div>

                <div class="card-content collapse show">

                    <div class="card-body card-dashboard dataTables_wrapper dt-bootstrap">

                        <div class="panel-heading">

                                <div class="container-fluid">

                                    <div class="row">

                                        @if(!Auth::user()->hasRole('Vendor'))

                                        <div class="col-lg-4 d-flex align-items-center justify-content-center p-1">

                                            <form id="myForm" action="{{ route('common.filter_kfupm_users') }}" method="post">

                                                @csrf

                                                <input type="date"  id="job_filter_value" class="form-control" name="job_registration_date">

                                                <button type="button" onclick="filter()" class="btn btn-info w-100 mt-0">Filter By Date of Registration</button>

                                            </form>

                                        </div>

                                        @endif

                                         <div class="col-lg-4 d-flex align-items-center justify-content-center p-1">

                                            <form action="{{ route('common.filter_by_major') }}" method="post">

                                                @csrf

                                                <select class="form-control " style="float:left" name="major">

                                                    <option value=" ">Choose Major</option>

                                                    @foreach($users as $user)

                                                    <option value="{{$user->major}}">{{$user->major}}</option>

                                                    @endforeach

                                                </select>

                                                <button type="submit" class="btn btn-info w-100 mt-0">Filter By Major</button>

                                            </form>

                                        </div>

                                        <!--university filter-->

                                        <div class="col-lg-4 d-flex align-items-center justify-content-center p-1">

                                            <form action="{{ route('common.filter_by_degree') }}" method="post">

                                                @csrf

                                                <select class="form-control " style="float:left" name="degree">

                                                    <option value=" ">Choose Degree</option>

                                                    @foreach($qualifications as $qualification)

                                                    <option value="{{$qualification->degree}}">{{$qualification->degree}}</option>

                                                    @endforeach

                                                </select>

                                                <button type="submit" class="btn btn-info w-100 mt-0">Filter By Degree</button>

                                            </form>

                                        </div>

                                        <!-- end -->

                                    </div>

                                    <p id="job_error" class="text-danger"></p>

                                    @if($errors->has('job_registration_date'))

                                                   <p class="text-danger">{{ $errors->first('job_registration_date') }}</p>

                                                @endif

                                               @if($errors->has('major'))

                                                   <p class="text-danger">{{ $errors->first('major') }}</p>

                                                @endif

                                               <!--  @if($errors->has('age'))

                                                   <p class="text-danger">{{ $errors->first('age') }}</p>

                                                @endif-->

                                    <!--@if($Kfupm_users['kfupm_user_detail'][0]->name == NULL)

                                    <h6 class="text-danger">No Result Found</h6>

                                    @endif-->

                                    </div>

                                </div>

                        <table id="kfupm_table" class="table table-striped table-bordered dom-jQuery-events">

                            <thead>

                                <tr>        

                                    <th>S.No</th>

                                    <th>Name</th>

                                    <th>Email</th>

                                    <!-- <th>Phone</th> -->

                                    <th>Contact</th>

                                    <th>Major</th>

                                    <th>Register Date</th>

                                    <th>View</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($KfupmUsers as $key =>$KfupmUser)

                                <tr data-entry-id="{{$key+1}}">

                                    <td>{{$key+1}}</td>

                                    <td>{{ $KfupmUsers[$key]->name ?? '' }}</td>

                                    <td>{{ $KfupmUsers[$key]->email ?? '' }}</td>

                                    <td>{{ $KfupmUsers[$key]->phone ?? '' }}</td>

                                    <td>{{ $KfupmUsers[$key]->major ?? '' }}</td>

                                    <td>{{ date('d-m-Y', strtotime($KfupmUsers[$key]->created_at))  ?? '' }}</td>

                                    <!-- <td>{{ $HrUser->phone ?? '' }}</td> -->

                                    <td>

                                        <a class="btn btn-xs btn-info" href="{{route('admin.kfupm_user.show',$KfupmUser->id)}}"><span class="material-icons">visibility</span></a>

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

@section('scripts')

<!-- jquery datepicker -->



<script src="{{ asset('filter-each-column/Filter.js')}}"></script>



<script>

function filter(){

 var abc =  document.getElementById("job_filter_value");

var b=abc.value;

console.log(b);

if(b!=''){

document.getElementById("myForm").submit();  

}

else{

    document.getElementById("job_error").innerHTML = "Please select a Date First";

}

}

</script>

<script>

$(document).ready(function(){

  $( function() {

    $("#datepicker" ).datepicker({  maxDate: new Date() , changeMonth: true, 

    changeYear: true, dateFormat: 'yy-mm-dd' });

 });});

  </script>

<!-- End jquery datepicker -->

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

@endsection

@endsection