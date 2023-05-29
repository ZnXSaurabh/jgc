@extends('layouts.admin')
@section('content')
<div class="content-body">
    @if (\Session::has('message'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('message') !!}</li>
        </ul>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    Candidate Profile
                </div>
                <div class="panel-body">

                    <table class="table table-bordered table-striped">
                        <tbody>


                            <tr>
                                <th>
                                    Name
                                </th>
                                <td>
                                    {{ $profile[0]->users->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email
                                </th>
                                <td>
                                    {{ $profile[0]->users->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Phone
                                </th>
                                <td>
                                    {{ $profile[0]->users->phone }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Gender
                                </th>
                                <td>
                                    {{ $profile[0]->gender }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Address
                                </th>
                                <td>
                                    {{ $profile[0]->address }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Address2
                                </th>
                                <td>
                                    {{ $profile[0]->address2 }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    City
                                </th>
                                <td>
                                    {{ $profile[0]->city }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    State
                                </th>
                                <td>
                                    {{ $profile[0]->state }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Zip Code
                                </th>
                                <td>
                                    {{ $profile[0]->zip_code }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Country
                                </th>
                                <td>
                                    {{ $profile[0]->country }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="panel-heading text-center text-center">
                        Education Details
                    </div>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    Level
                                </th>
                                <th>
                                    Course
                                </th>
                                <th>
                                    University
                                </th>
                                <th>
                                    Start Year
                                </th>
                                <th>
                                    End Year
                                </th>
                                <th>
                                    Percentage
                                </th>
                            </tr>
                            @foreach($educations as $education)
                            <tr>
                                <td>
                                    {{$education->level}}
                                </td>
                                <td>
                                    {{$education->course}}
                                </td>
                                <td>
                                    {{$education->university}}
                                </td>
                                <td>
                                    {{$education->start_year}}
                                </td>
                                <td>
                                    {{$education->end_year}}
                                </td>
                                <td>
                                    {{$education->percentage}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="panel-heading text-center">
                        Experience Details
                    </div>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    Level
                                </th>
                                <th>
                                    Designation
                                </th>
                                <th>
                                    Department
                                </th>
                                <th>
                                    Organisation
                                </th>
                                <th>
                                    Start Year
                                </th>
                                <th>
                                    End Year
                                </th>
                            </tr>
                            @foreach($experiences as $experience)
                            <tr>
                                <td>
                                    {{$experience->level}}
                                </td>
                                <td>
                                    {{$experience->designation}}
                                </td>
                                <td>
                                    {{$experience->department}}
                                </td>
                                <td>
                                    {{$experience->organisation}}
                                </td>
                                <td>
                                    {{$experience->start_year}}
                                </td>
                                <td>
                                    {{$experience->end_year}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    Resume
                                </th>
                                <td>
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ \Illuminate\Support\Facades\Storage::url($profile[0]->resume) }}"
                                        download>
                                        Download
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Add to shortlist
                                </th>
                                <td>
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.jobs.shortlist', $JobApplied->id) }}">
                                        Shortlist
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>



        </div>
    </div>
</div>
@endsection
