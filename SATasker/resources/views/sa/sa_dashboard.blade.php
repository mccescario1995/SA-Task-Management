@extends('layouts.app')

@section('title', 'Dashboard - Student Assistant')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div class="main-background">
        @php
            use App\Models\SaTaskTimeLog;
        @endphp
        <div style="padding: 3em;">
            <section>
                <h1>Voluntary Tasks</h1>
                @if (session('accept_task_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('accept_task_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" aria-label="Close">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" aria-label="Close">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" aria-label="Close">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </div>
                @endif
                <div class="table-responsive" style="padding: 1em;">
                    <table class="table table-hover table-border rounded">
                        <thead class="background-accent1">
                            <tr>
                                <th class="table-border2 rounded">TASK NO.</th>
                                <th class="table-border2 rounded">DATE &amp; TIME</th>
                                <th class="table-border2 rounded">PROGRAM</th>
                                <th class="table-border2 rounded">OFFICE</th>
                                <th class="table-border2 rounded">NOTE</th>
                                <th class="table-border2 rounded"></th>
                            </tr>
                        </thead>
                        <tbody class="background-accent3">
                            @if ($urgentTasks->count() == 0)
                                <tr class="text-center">
                                    <td class="table-border2 rounded" colspan="6"><strong> No Task Available </strong>
                                    </td>
                                </tr>
                            @else
                                @foreach ($urgentTasks as $task)
                                    @php
                                        $saCount = DB::table('user_tasks_timelog')
                                            ->where('task_id', $task->id)
                                            ->where('task_status', 1)
                                            ->count();
                                        $isAccepted = DB::table('user_tasks_timelog')
                                            ->where('user_id', '=', $user->id)
                                            ->where('task_id', '=', $task->id)
                                            ->exists();
                                        //dd($isAccepted);
                                    @endphp
                                    <tr class="background-accent3">
                                        <td class="table-border2 rounded">{{ $task->id }}</td>
                                        <td class="table-border2 rounded">{{ $task->start_date }}</td>
                                        <td class="table-border2 rounded">{{ $task->preffred_program }}</td>
                                        <td class="table-border2 rounded">{{ $task->assigned_office }}</td>
                                        <td class="table-border2 rounded">{{ $task->note }}</td>
                                        @if ($saCount == $task->number_of_sa)
                                            <td class="table-border2 rounded">
                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                <button type="submit" class="btn btn-secondary">Full</button>
                                            </td>
                                        @elseif ($isAccepted)
                                            <td class="table-border2 rounded">
                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                <button type="submit" class="btn btn-primary" disabled>Accepted</button>
                                            </td>
                                        @else
                                            <form action="{{ route('sa.accept', $task->id) }}" method="post">
                                                @csrf
                                                <td class="table-border2 rounded">
                                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                    <button type="submit" class="btn btn-primary">Accept</button>
                                                </td>
                                            </form>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div>
                        {{ $urgentTasks->links() }}
                    </div>
                </div>
            </section>
        </div>

        <div style="padding: 3em;border-top-style: groove;">
            <section>
                <h1>Tasks</h1>
                <div class="table-responsive" style="padding: 1em;">
                    <table class="table table-hover table-border rounded">
                        <thead class="background-accent1">
                            <tr>
                                <th class="table-border2 rounded">TASK NO.</th>
                                <th class="table-border2 rounded">DATE &amp; TIME</th>
                                <th class="table-border2 rounded">PROGRAM</th>
                                <th class="table-border2 rounded">Task</th>
                                <th class="table-border2 rounded">Office</th>
                                <th class="table-border2 rounded">Note</th>
                                <th class="table-border2 rounded" colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody class="background-accent3">
                            @if ($assignedTasks->count() == 0)
                                <tr class="text-center">
                                    <td class="table-border2 rounded" colspan="7"><strong> No Task Available </strong>
                                    </td>
                                </tr>
                            @else
                                @foreach ($assignedTasks as $assignedtask)
                                    <tr>
                                        <td class="table-border2 rounded">{{ $assignedtask->task_id }}</td>
                                        <td class="table-border2 rounded">
                                            <p style="margin: 0px;">{{ $assignedtask->start_date }}</p>
                                            <p style="font-size: 12px;">{{ $assignedtask->start_time }} -
                                                {{ $assignedtask->end_time }}</p>
                                        </td>
                                        <td class="table-border2 rounded">{{ $assignedtask->preffred_program }}</td>
                                        <td class="table-border2 rounded">{{ $assignedtask->to_be_done }}</td>
                                        <td class="table-border2 rounded">
                                            <p style="margin: 0px;">{{ $assignedtask->assigned_office }}</p>
                                            <p style="font-size: 12px;">
                                                {{ DB::table('users')->where('users.id', '=', $assignedtask->office_id)->select('users.email')->first()->email }}
                                            </p>
                                        </td>
                                        <td class="table-border2 rounded">{{ $assignedtask->note }}</td>
                                        <td class="table-border2 rounded">
                                            <form action="{{ route('sa.timein') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="task_id" value="{{ $assignedtask->task_id }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                @if (!SaTaskTimeLog::where('task_id', $assignedtask->task_id)->where('user_id', $user->id)->whereDate('time_in', now()->toDateString())->exists())
                                                    <button type="submit" class="btn btn-primary">Time-In</button>
                                                @else
                                                    <button type="submit" class="btn btn-secondary disabled"
                                                        disabled>Time-In</button>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="table-border2 rounded">
                                            <form action="{{ route('sa.timeout') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="task_id"
                                                    value="{{ $assignedtask->task_id }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                @if (!SaTaskTimeLog::where('task_id', $assignedtask->task_id)->where('user_id', $user->id)->whereDate('time_out', now()->toDateString())->exists())
                                                    <button type="submit" class="btn btn-primary">Time-Out</button>
                                                @else
                                                    <button type="submit" class="btn btn-secondary disabled"
                                                        disabled>Time-Out</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div>
                        {{ $assignedTasks->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>


    @include('nav.offcanvas_menu_sa')
@endsection
