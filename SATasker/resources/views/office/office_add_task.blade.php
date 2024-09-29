@extends('layouts.app')

@section('title', 'Dashboard - Office')

@section('content')
    <!-- Your content here -->
    @include('include.nav_bar')
    <div class="main-background text-accent2">

        <div class="rounded border-accent1 m-auto mt-5 w-75 p-5">
            <div class="text-center mb-3">

                <div>
                    <h2>Add Task</h2>
                </div>

                <hr class="border-accent2 rounded w-25 m-auto" style="opacity: .75;">
            </div>
            <form action="{{ route('office.add') }}" method="POST" id="addTaskForm">
                @csrf
                <div>
                    <div class="row">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col">
                            <div>


                                <div>
                                    <div class="row">
                                        <div class="col-11" style="margin: 1em;">
                                            <div><label class="form-label"><strong>Date *</strong></label></div>
                                            <div><input class="form-control w-100" id="start_date" name="start_date"
                                                    type="date" style="width: 200px;font-size: 20px;">
                                            </div>
                                        </div>
                                        <div class="col-11" style="margin: 1em;">
                                            <div><label class="form-label"><strong>Time *</strong></label></div>
                                            <div class="row p-2">
                                                <input class="form-control col" id="start_time" name="start_time"
                                                    type="time" style="width: 150px; margin:5px;">
                                                <input class="form-control col" id="end_time" name="end_time"
                                                    type="time" style="width: 150px; margin:5px;">
                                            </div>

                                        </div>
                                        <div class="col-11" style="margin: 1em;">
                                            {{-- <div class="co" > --}}
                                            <div><label class="form-label"><strong>No. of Student Assistant
                                                        *</strong></label></div>
                                            <div><input class="form-control w-100 m-auto" id="number_of_sa"
                                                    name="number_of_sa" type="number" style="width: 5em;font-size: 20px;">
                                            </div>

                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-11 p-2" style="margin: 1em;">
                                            <div><label class="form-label"><strong>Program </strong>(optional)</label></div>
                                            <div>
                                                <select class="form-select" id="preffred_program" name="preffred_program"
                                                    aria-label="Default select example">
                                                    <option selected disable>Select a Program</option>
                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <div>
                                    <div class="row">
                                        <div class="col-11" style="margin: 1em;">
                                            <div>
                                                <label class="form-label">
                                                    <strong>Task Assignment Type </strong>*
                                                </label>
                                            </div>
                                            <div id="assignment_type" class="px-3">
                                                <div class="form-check" style="margin: auto;">
                                                    <input class="form-check-input" type="radio" name="assignment_type"
                                                        id="formCheck-3" value="1">
                                                    <label class="form-check-label" for="formCheck-3">Auto
                                                        Assignment</label>
                                                </div>
                                                <div class="form-check" style="margin: auto;">
                                                    <input class="form-check-input" type="radio" name="assignment_type"
                                                        id="formCheck-4" value="2">
                                                    <label class="form-check-label" for="formCheck-4">Voluntary</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-11" style="margin: 1em;">
                                            <div><label class="form-label"><strong>Tasks to be done</strong>
                                                    (optional)</label></div>
                                            <div class="d-xl-flex align-items-xl-center">
                                                <input class="form-control w-100" id="to_be_done" name="to_be_done"
                                                    type="text" style="width: 20em;height: 5em;">
                                            </div>
                                        </div>
                                        <div class="col-11" style="margin: 1em;">
                                            <div><label class="form-label"><strong>Note </strong>(contact person, what to
                                                    bring, etc.)</label></div>
                                            <div class="d-xl-flex align-items-xl-center">
                                                <input class="form-control w-100" id="note" name="note"
                                                    type="text" style="width: 20em;height: 5em;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-xl-flex justify-content-xl-center mt-5">
                    <button class="btn background-accent2 text-accent1 w-25 py-2" type="submit">Add
                        Task</button>
                </div>
        </div>
        </form>
    </div>
    </div>
    @include('nav.offcanvas_menu_office')
@endsection
