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
                        <span class="users-view-name">{{ $candidate->name ?? '' }} </span><span class="text-muted font-medium-1">#</span><span class="users-view-username text-muted font-medium-1"><em>{{ $candidate->email ?? '' }}</em></span>
                        </h4>
                        <span>ID:</span>
                        <span class="users-view-id">{{ $candidate->id ?? '' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
                <a class="btn btn-sm btn-primary" href="{{ route('common.candidate.index') }}"><span class="material-icons">keyboard_backspace</span> Back</a>
            </div>
        </div>
        <!-- users view media object ends -->
        <!-- users view card data start -->
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Registered:</td>
                                        <td>{{ date('d-m-Y', strtotime($candidate->created_at))  ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Verified:</td>
                                        <td class="users-view-verified">@if($candidate->status == 1) Yes @else No @endif</td>
                                    </tr>
                                    <tr>
                                        <td>Role:</td>
                                        <td class="users-view-role">{{ $candidate->roles[0]->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td><span class="badge @if($candidate->status == 1) badge-success @else badge-danger @endif users-view-status">@if($candidate->status == 1) Active @else Inactive @endif</span></td>
                                    </tr>
                                    <tr>
                                        <td>Resume:</td>
                                        <td><a class="btn btn-xs btn-primary" href="{{ \Illuminate\Support\Facades\Storage::url($candidate->resume) }}" download>Download</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="col-12 col-md-8">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Module Permission</th>
                                            <th>Read</th>
                                            <th>Write</th>
                                            <th>Create</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Users</td>
                                            <td>Yes</td>
                                            <td>No</td>
                                            <td>No</td>
                                            <td>Yes</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
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
                                    <td>Username:</td>
                                    <td class="users-view-username">{{ $candidate->email }}</td>
                                </tr>
                                <tr>
                                    <td>Name:</td>
                                    <td class="users-view-name">{{ $candidate->name }}</td>
                                </tr>
                                <tr>
                                    <td>Phone:</td>
                                    <td>{{ $candidate->phone }}</td>
                                </tr>
                                <tr>
                                    <td>E-mail:</td>
                                    <td class="users-view-email">{{ $candidate->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h5 class="mb-1"><span class="material-icons">info</span> Personal Info</h5>
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td>Birthday:</td>
                                    <td>{{ $candidate->dob }}</td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td>{{ $candidate->country }}</td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>{{ $candidate->city }}</td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>{{ $candidate->address }}</td>
                                </tr>
                                <tr>
                                    <td>Gender:</td>
                                    <td>{{ $candidate->gender }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h5 class="mb-1"><span class="material-icons" style="width:36px">cast_for_education</span>Education Details</h5>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Level</th>
                                    <th>Course</th>
                                    <th>University</th>
                                    <th>Start Year</th>
                                    <th>End Year</th>
                                    <th>Percentage</th>
                                </tr>
                                @foreach(json_decode($education->level, true) as $key => $level)
                                <tr>
                                    <td>{{ $level }}</td>
                                    <td>{{ json_decode($education->course, true)[$key] }}</td>
                                    <td>{{ json_decode($education->university, true)[$key] }}</td>
                                    <td>{{ json_decode($education->start_year, true)[$key] }}</td>
                                    <td>{{ json_decode($education->end_year, true)[$key] }}</td>
                                    <td>{{ json_decode($education->percentage, true)[$key] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <h5 class="mb-1"><span class="material-icons">explicit</span> Experience Details</h5>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Level</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>Organisation</th>
                                    <th>Start Year</th>
                                    <th>End Year</th>
                                </tr>
                                @foreach(json_decode($experience->level, true) as $key => $level)
                                <tr>
                                    <td>{{ $level }}</td>
                                    <td>{{ json_decode($experience->designation, true)[$key] }}</td>
                                    <td>{{ json_decode($experience->department, true)[$key] }}</td>
                                    <td>{{ json_decode($experience->organisation, true)[$key] }}</td>
                                    <td>{{ json_decode($experience->start_year, true)[$key] }}</td>
                                    <td>{{ json_decode($experience->end_year, true)[$key] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection