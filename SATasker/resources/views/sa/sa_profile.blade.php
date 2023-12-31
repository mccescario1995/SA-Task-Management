@extends('layouts.app')

@section('title', 'Dashboard - Student Assistant')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div>
    <div style="padding: 3em;border-bottom-style: dashed;">
            @foreach($userProfile as $userProfile)
            <div class="d-lg-flex align-items-lg-center">
                <p class="d-lg-flex" style="font-weight: bold;">Name :&nbsp;</p>
                <p>{{$userProfile->first_name}} {{$userProfile->middle_initial}}. {{$userProfile->last_name}}</p>
            </div>
            <div class="d-lg-flex align-items-lg-center">
                <p class="d-lg-flex" style="font-weight: bold;">Student ID :&nbsp;</p>
                <p>{{$user->id_number}}</p>
            </div>
            <div class="d-lg-flex align-items-lg-center">
                <p class="d-lg-flex" style="font-weight: bold;">Program :&nbsp;</p>
                <p>{{$userProfile->course_program}}</p>
            </div>
            <div class="d-lg-flex align-items-lg-center">
                <p class="d-lg-flex" style="font-weight: bold;">Contact Details :&nbsp;</p>
                <p>{{$user->email}} | {{$userProfile->contact_number}}</p>
            </div>
            @endforeach
        </div>
        <div style="padding: 2em;">
            <section>
                <h3 style="text-align: center;">Class Schedule</h3>
                <h6 style="text-align: center;margin-bottom: 0px;">SY 2023- 2024 Term 1</h6>
                <div class="table-responsive" style="padding: 1em;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style="background: #d9d9d9;">Subject</th>
                                <th scope="col" style="background: #d9d9d9;">Section</th>
                                <th scope="col" style="background: #d9d9d9;">Day</th>
                                <th style="background: #d9d9d9;">Time</th>
                                <th style="background: #d9d9d9;">Instructor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Subject Code" scope="row">Attribute 1</td>
                                <td data-label="Section">Cell 2</td>
                                <td data-label="Day">Cell 3</td>
                                <td data-label="Time">Cell 4</td>
                                <td data-label="Instructor">Cell 5</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div style="padding: 2em;">
            <section>
                <h3 style="text-align: center;">Task History</h3>
                <h6 style="text-align: center;margin-bottom: 0px;">0/90 Hours Rendered</h6>
                <div class="table-responsive" style="padding: 1em;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" style="background: #d9d9d9;">Task no.</th>
                                <th scope="col" style="background: #d9d9d9;">Date &amp; Time</th>
                                <th style="background: #d9d9d9;">Program</th>
                                <th scope="col" style="background: #d9d9d9;">Task</th>
                                <th style="background: #d9d9d9;">Office</th>
                                <th style="background: #d9d9d9;">Note</th>
                                <th style="background: #d9d9d9;">Hours</th>
                                <th style="background: #d9d9d9;">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($taskHistory as $taskHistory)
                            <tr>
                                <td data-label="Task No." scope="row">{{$taskHistory->id}}</td>
                                <td data-label="Date &amp; Time">{{$taskHistory->start_date}}</td>
                                <td data-label="Program">{{$taskHistory->preffred_program}}</td>
                                <td data-label="Task">{{$taskHistory->to_be_done}}</td>
                                <td data-label="Office">{{$taskHistory->assigned_office}}</td>
                                <td data-label="Note">{{$taskHistory->note}}</td>
                                <td data-label="Hours">{{$taskHistory->hours_rendered}}</td>
                                <td data-label="Feedback">{{$taskHistory->feedback}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>


    @include('nav.offcanvas_menu_sa')
@endsection