@extends('layouts.app')

@section('title', 'SA Reports - Student Assistant Manager')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div class="text-center main-background">
        @php
            use App\Models\Offense;
        @endphp
        <div
            class="background-accent1 py-2 border-accent2 rounded mb-1 d-xl-flex justify-content-xl-center align-items-xl-center mt-4">
            <h2 class="text-accent2 mb-0">SA Records</h2>
        </div>
        <div
            class="d-flex d-lg-flex justify-content-center justify-content-lg-center align-items-lg-center border-bottom-accent2 pt-2 px-5 pb-2">
            <div class="row">
                <div class="col text-center mb-3">
                    <button onclick="window.location.href='{{ route('report.saReport', 'ongoing') }}'"
                        class="btn
                            @if ($status === 'ongoing') going background-accent1 text-accent2 border text-nowrap active-going fw-bolder
                            @else
                            going background-accent2 text-accent1 border opacity @endif
                            "
                        type="button">
                        <h4 class="text-uppercase fw-bold mb-0">On-going</h4>
                    </button>
                </div>
                <div class="col text-center mb-3">
                    <button onclick="window.location.href='{{ route('report.saReport', 'completed') }}'"
                        class="btn
                        @if ($status === 'ongoing') going background-accent2 text-accent1 border opacity
                        @else
                            going background-accent1 text-accent2 border text-nowrap active-going fw-bolder @endif
                        "
                        type="button">
                        <h4 class="text-uppercase fw-bold mb-0">Completed</h4>
                    </button>
                </div>
            </div>
        </div>
        <section class="border-top-accent2">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </div>
            @endif
            <div class="table-responsive" style="padding: 1em;">
                <table class="table table-hover table-border rounded">
                    <thead class="background-accent1">
                        <tr>
                            <th class="table-border2 rounded">Student Name</th>
                            <th class="table-border2 rounded">Student ID Number</th>
                            <th class="table-border2 rounded">Student Email</th>
                            <th class="table-border2 rounded">Hours Rendered</th>
                            <th class="table-border2 rounded">SA Scholarship Status</th>
                        </tr>
                    </thead>
                    {{-- @if ($status === 'ongoing') --}}
                    <tbody class="background-accent3">
                        @if ($saLists->count() == 0)
                            <tr>
                                <td class="table-border2 rounded text-center" colspan="5">
                                    <strong>No SA with {{ $status === 'ongoing' ? 'On-going' : 'Completed' }} Tasks</strong>
                                </td>
                            </tr>
                        @else
                            @foreach ($saLists as $task)
                                @php
                                    $scholarshipStatus = $offenses[optional($task->user)->id_number] ?? null;
                                @endphp

                                <tr>
                                    <td class="table-border2 rounded text-center">
                                        {{ $task->user->saProfile->first_name ?? 'N/A' }}
                                        {{ $task->user->saProfile->last_name ?? 'N/A' }}
                                    </td>
                                    <td class="table-border2 rounded text-center">
                                        {{ $task->user->id_number ?? 'N/A' }}
                                    </td>
                                    <td class="table-border2 rounded text-center">
                                        {{ $task->user->email ?? 'N/A' }}
                                    </td>
                                    <!-- Display hours rendered logic -->
                                    <td class="table-border2 rounded text-center">
                                        <strong>
                                            {{ $task->total_rendered_hours ?? 'Not Started' }}
                                        </strong>
                                    </td>
                                    <!-- Display SA status logic -->
                                    <td class="table-border2 rounded text-center text-capitalize fw-bolder">
                                        {{-- {{ $task->user->saProfile->status == 'active' || $task->user->saProfile->status == 'pending' ? 'Active' : $task->user->saProfile->status }} --}}
                                        @if (optional(optional($task->user)->saProfile)->status === 'pending_revoke')
                                            Pending Revocation
                                            @if (optional($scholarshipStatus)->type === 'major')
                                                (D.O.)
                                            @elseif(optional($scholarshipStatus)->type === 'grade')
                                                (Guidance)
                                            @endif
                                        @else
                                            {{ optional(optional($task->user)->saProfile)->status ?? 'No Status' }}
                                            @if (optional(optional($task->user)->saProfile)->status)
                                                @if (optional($scholarshipStatus)->type === 'major')
                                                    (D.O.)
                                                @elseif(optional($scholarshipStatus)->type === 'grade')
                                                    (Guidance)
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
        @include('nav.offcanvas_menu_sam')
    </div>
@endsection
