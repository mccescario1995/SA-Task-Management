@extends('layouts.app')

@section('title', 'Dashboard - Office')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div class="text-center" style="padding: 3em;">
            <section class="mt-5">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </div>
                @endif
                <div class="table-responsive" style="padding: 1em;">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="table-warning">
                                <th scope="col">Task No.</th>
                                <th scope="col">Date &amp; Time</th>
                                <th scope="col">Program</th>
                                <th>Task</th>
                                <th>Hours</th>
                                <th>Note</th>
                                <th>Task Accepts</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($tasks->count() == 0)
                                <tr>
                                        <td data-label="No Inactive Task Available" scope="row" colpan="6"><strong> No Inactive Task Available </strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                </tr>
                            @else
                                @foreach($tasks as $task)
                                    @php
                                        $startTime = strtotime($task->start_time);
                                        $endTime = strtotime($task->end_time);
                                        $startTimeampm = date("h:i A", strtotime($task->start_time));
                                        $endTimeampm = date("h:i A", strtotime($task->end_time));
                                        $totalHours = round(($endTime - $startTime) / 3600, 1);
                                        $saCount = (DB::table('user_tasks_timelog')->where('task_id',$task->id)->where('task_status',1)->count()) ? DB::table('user_tasks_timelog')->where('task_id',$task->id)->where('task_status',1)->count() : '0' ;
                                    @endphp
                                <tr>
                                    <td data-label="{{$task->id}}" scope="row">{{$task->id}}</td>
                                    <td data-label="{{$task->start_date}}">
                                        <div>
                                            <div>{{$task->start_date}}</div>
                                            <div style="font-size: 11px">{{$startTimeampm}} - {{$endTimeampm}}</div>
                                        </div>    
                                    </td>
                                    <td data-label="{{$task->preffred_program}}">{{$task->preffred_program}}</td>
                                    <td data-label="{{$task->to_be_done}}">{{$task->to_be_done}}</td>
                                    <td data-label="{{$task->id}}">{{$totalHours}}</td>
                                    <td data-label="{{$task->id}}">{{$task->note}}</td>
                                    <td data-label="{{ $saCount }} /{{$task->number_of_sa}} ">
                                        <a href="{{ route('office.saList', $task->id) }}" class="btn 
                                        @if ($saCount < $task->number_of_sa)
                                             btn-outline-success 
                                        @elseif ($saCount == $task->number_of_sa) 
                                            btn-outline-danger 
                                        @endif
                                        " > 
                                        @if ($saCount < $task->number_of_sa)
                                            {{ $saCount }} /{{$task->number_of_sa}} 
                                        @elseif ($saCount == $task->number_of_sa) 
                                            Full
                                        @endif
                                            
                                        </a>
                                    </td>

                                    <td style="font-weight: bold;">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal-{{ $task->id }}">Edit</button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTaskModal-{{ $task->id }}">Delete</button>
                                    </td>
                                    @include('modals.edit_task')
                                    @include('modals.delete_task')
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
            <div style="text-align: center;">
                <button class="btn btn-success" type="button"  data-bs-toggle="modal" data-bs-target="#addTask">&nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-plus-lg" style="width: 25px;height: 25px;">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"></path>
                    </svg> &nbsp;Add Task</button></div>
        </div>
        @if($tasks->count() >= 1)
            @include('modals.edit_task')
        @endif
    @include('modals.add_task')
    @include('nav.offcanvas_menu_office')
@endsection