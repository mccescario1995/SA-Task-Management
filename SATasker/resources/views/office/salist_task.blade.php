@extends('layouts.app')

@section('title', 'SA List - Office')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div class="text-center" style="padding: 3em;">
    <section>
            @if (session('add_task_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('add_task_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </div>
            @endif
    </section>
    <div style="padding: 3em;">
    <div class="d-xl-flex justify-content-xl-center align-items-xl-center" style="width: 100%;height: 4em;">
        <h3>Task Review</h3>
    </div>
    <section>
        <div class="d-xl-flex justify-content-xl-center align-items-xl-center" style="width: 100%;height: 3em;padding: 8px;background: #d9d9d9;margin: 0px;">
            <h5>Task </h5>
        </div>
        <div class="table-responsive" style="padding: 1em;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="background: #d9d9d9;">Student No.</th>
                        <th scope="col" style="background: #d9d9d9;">SA Name</th>
                        <th scope="col" style="background: #d9d9d9;">Course</th>
                        <th style="background: #d9d9d9;">Time In</th>
                        <th style="background: #d9d9d9;">Time Out</th>
                        <th style="background: #d9d9d9;">Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saLists as $saList)
                        <tr>
                            <td data-label="Attributes" scope="row">{{$saList->user_id}}</td>
                            <td data-label="Base Class">{{$saList->first_name}} {{$saList->last_name}}</td>
                            <td data-label="Simulated Case">{{$saList->course_program}}</td>
                            <td>{{$saList->timein}}</td>
                            <td>{{$saList->timeout}}</td>
                            @php
                            $timeIn = \Carbon\Carbon::parse($saList->timein);
                            $timeOut = \Carbon\Carbon::parse($saList->timeout);

                            // Calculate working hours difference
                            $workingHours = $timeOut->diffInMinutes($timeIn) / 60;
                            $roundedWHrs = round($workingHours,2);
                            @endphp
                            <td>{{$roundedWHrs}} Hr(s)</td>
                            <td style="font-weight: bold;">
                                <button class="btn btn-warning" type="button" style="background: rgba(13,110,253,0);color: rgb(0,0,0);border-style: none;" data-bs-toggle="modal" data-bs-target="#addFeedback">
                                    <strong>Add Feedback</strong>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
    @include('nav.offcanvas_menu_office')
@endsection