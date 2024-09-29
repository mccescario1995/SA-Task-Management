@extends('layouts.app')

@section('title', 'Profile - Student Assistant')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div class="main-background p-4 pt-0 ">
        <div class="profile-divider pt-3" style="padding: 3em;">
            @foreach ($userProfiles as $userProfile)
                <div class="d-lg-flex align-items-lg-center mt-2">
                    <p class="d-lg-flex  h4" style="font-weight: bold;">&nbsp; Name :&nbsp;</p>
                    <p class="mb-0">{{ $userProfile->first_name }} {{ $userProfile->middle_initial }}. {{ $userProfile->last_name }}</p>
                </div>
                <div class="d-lg-flex align-items-lg-center">
                    <p class="d-lg-flex  h4" style="font-weight: bold;">&nbsp; Student ID :&nbsp;</p>
                    <p class="mb-0">{{ $user->id_number }}</p>
                </div>
                <div class="d-lg-flex  align-items-lg-center">
                    <p class="d-lg-flex h4" style="font-weight: bold;">&nbsp; Program :&nbsp;</p>
                    <p class="mb-0">{{ $userProfile->course_program }}</p>
                </div>
                <div class="d-lg-flex  align-items-lg-center">
                    <p class="d-lg-flex h4" style="font-weight: bold;">&nbsp; Contact Details :&nbsp;</p>
                    <p class="mb-0">{{ $user->email }} | +{{ $userProfile->contact_number }}</p>
                </div>
            @endforeach
        </div>
        <div style="padding: 2em; ">
            <section>
                <h2 style="text-align: center;">Class Schedule</h2>
                <h6 style="text-align: center;margin-bottom: 0px;">SY {{ $term }} Term 1</h6>
                <div class="table-responsive" style="padding: 1em;">
                    <table class="table table-hover table-border rounded">
                        <thead class="background-accent1">
                            <tr>
                                <th class="table-border2 rounded">Subject</th>
                                <th class="table-border2 rounded">Section</th>
                                <th class="table-border2 rounded">Day</th>
                                <th class="table-border2 rounded">Time</th>
                                <th class="table-border2 rounded">Instructor</th>
                            </tr>
                        </thead>
                        <tbody class="background-accent3">
                            @forelse($schedule as $class)
                                <tr class="{{ $loop->odd ? 'bg-light' : 'bg-white' }} text-center">
                                    <td class="table-border2 rounded" data-label="Subject Code" aria-label="Subject Code">
                                        {{ $class->subject_code }}</td>
                                    <td class="table-border2 rounded" data-label="Section" aria-label="Section">
                                        {{ $class->section }}</td>
                                    <td class="table-border2 rounded" data-label="Day" aria-label="Day">{{ $class->day }}</td>
                                    <td class="table-border2 rounded" data-label="Time" aria-label="Time">
                                        {{ $class->time_constraints }}</td>
                                    <td class="table-border2 rounded" data-label="Instructor" aria-label="Instructor">
                                        {{ $class->instructor->name ?? 'TBA' }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td class="table-border2 rounded" colspan="5">No Schedule Yet</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </section>
        </div>
        <div style="padding: 2em; padding-top:0;">
            <section>
                <h2 style="text-align: center;">Task History</h2>
                <h6 style="text-align: center;margin-bottom: 0px;">

                    @foreach ($rendered as $render)
                        @if (empty($render->total_hours) && $render->total_hours === null)
                            0
                        @else
                            {{ $render->total_hours }}
                        @endif
                    @endforeach

                    / {{ $taskHistories->total() * 90 }} Hour(s) Rendered
                </h6>
                <div class="table-responsive" style="padding: 1em;">
                    <table class="table table-hover table-border rounded">
                        <thead>
                            <tr class="text-center align-items-center background-accent1 ">
                                <th class="table-border2 rounded">Task no.</th>
                                <th class="table-border2 rounded">Task Date &amp; Time</th>
                                <th class="table-border2 rounded">Latest Time-In</th>
                                <th class="table-border2 rounded">Latest Time-Out</th>
                                <th class="table-border2 rounded">Hours Rendered</th>
                                <th class="table-border2 rounded">Program </th>
                                <th class="table-border2 rounded">Task</th>
                                <th class="table-border2 rounded">Office</th>
                                <th class="table-border2 rounded">Note</th>
                                <th class="table-border2 rounded">Latest Feedback</th>
                            </tr>
                        </thead>
                        <tbody class="background-accent3">
                            @forelse($taskHistories as $taskHistory)
                                <tr class="{{ $loop->odd ? 'bg-light' : 'bg-white' }} text-center">
                                    <td class="table-border2 rounded" data-label="Task No." scope="row">{{ $taskHistory->id }}</td>
                                    <td class="table-border2 rounded" data-label="Date &amp; Time">{{ $taskHistory->start_date }}</td>
                                    <td class="table-border2 rounded" data-label="Time In">
                                        {{ $taskHistory->time_in ?? 'No Time-In Yet' }}
                                    </td>
                                    <td class="table-border2 rounded" data-label="Time Out">
                                        {{ $taskHistory->time_out ?? 'No Time-Out Yet' }}
                                    </td>
                                    <td class="table-border2 rounded" data-label="Total Hours">
                                        {{ $taskHistory->total_hours ?? 'No Rendered Hrs' }}
                                    </td>
                                    <td class="table-border2 rounded" data-label="Program">{{ $taskHistory->preffred_program }}</td>
                                    <td class="table-border2 rounded" data-label="Task">{{ $taskHistory->to_be_done }}</td>
                                    <td class="table-border2 rounded" data-label="Office">{{ $taskHistory->assigned_office }}</td>
                                    <td class="table-border2 rounded" data-label="Note">{{ $taskHistory->note }}</td>
                                    <td class="table-border2 rounded" data-label="Feedback">
                                        {{ $taskHistory->feedback ?? 'No Feedback' }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td class="table-border2 rounded" colspan="10"><strong>No Pending Task/s</strong></td>
                                </tr>
                            @endforelse
                        </tbody>

                        </tbody>
                    </table>
                    <div>
                        {{ $taskHistories->onEachSide(5)->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>


    @include('nav.offcanvas_menu_sa')
@endsection
