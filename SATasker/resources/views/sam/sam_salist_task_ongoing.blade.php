@extends('layouts.app')

@section('title', 'SA List - SA Manager')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div class="text-center" style="padding: 3em;">

    <div style="padding: 3em;">
    <div class="d-xl-flex justify-content-xl-center align-items-xl-center" style="width: 100%;height: 4em;">
        <h3>List of Student Assistant</h3>
    </div>
    <section>
        <div class="d-xl-flex justify-content-xl-center align-items-xl-center" style="width: 100%;height: 3em;padding: 8px;background: #d9d9d9;margin: 0px;">
            <h5>Task {{$taskId}}</h5>
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
                            <td>
                                @if($saList->timein == null)
                                    No Time-In Yet
                                @else
                                    {{$saList->timein}}
                                @endif
                            </td>
                            <td>
                                @if($saList->timeout == null)
                                    No Time-Out Yet
                                @else
                                    {{$saList->timeout}}
                                @endif
                            </td>
                            @php
                            $timeIn = \Carbon\Carbon::parse($saList->timein);
                            $timeOut = \Carbon\Carbon::parse($saList->timeout);

                            // Calculate working hours difference
                            $workingHours = $timeOut->diffInMinutes($timeIn) / 60;
                            $roundedWHrs = round($workingHours,3);

                            @endphp
                            <td>
                                @if($roundedWHrs <= 0 )
                                    Not Yet Started
                                @else
                                    {{$roundedWHrs}} Hr(s) 
                                @endif
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