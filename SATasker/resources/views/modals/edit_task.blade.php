<div class="modal fade modal-lg" role="dialog" tabindex="-1" id="editTaskModal-{{ $task->id }}"  aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Edit Task</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('office.edit', $task->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div>
                                        <div>
                                            <div class="row">
                                                <div class="col" style="margin: 1em;">
                                                    <div><label class="form-label"><strong>Date *</strong></label></div>
                                                    <div><input name="start_date" type="date" style="width: 200px;font-size: 20px;" required value="{{$task->start_date}}"></div>
                                                </div>
                                                <div class="col" style="margin: 1em;">
                                                    <div><label class="form-label">
                                                        <strong>Time *</strong></label></div>
                                                    <div class="d-xl-flex align-items-xl-center">
                                                    <input name="start_time" type="time" style="width: 150px;margin: auto;" value="{{ $task->start_time }}">
                                                    <input name="end_time" type="time" style="width: 150px;margin: auto;" value="{{ $task->end_time }}">
                                                </div>
                                                </div>
                                                <div class="col " style="margin: 1em;">
                                                    <div><label class="form-label"><strong>No. of student assistant *</strong></label></div>
                                                    <div><input name="number_of_sa" type="number" style="width: 5em;font-size: 20px;" required value="{{$task->number_of_sa}}"></div>
                                                </div>
                                                <div class="col" style="margin: 1em;">
                                                    <div><label class="form-label"><strong>Program </strong>(optional)</label></div>
                                                    <div>
                                                        <select name="preffred_program" class="form-select form-select-m" aria-label="Default select example" placeholder="{{ $task->preffred_program }}">
                                                            <option value="Course 1">Course 1</option>
                                                            <option value="Course 2">Course 2</option>
                                                            <option value="Course 3">Course 3</option>
                                                            <option value="Course 4">Course 4</option>
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
                                                <div class="col" style="margin: 1em;">
                                                    <div>
                                                        <label class="form-label"><strong>Task Assignment Type </strong>*</label>
                                                    </div>
                                                    <div class="d-xl-flex align-items-xl-center">
                                                        <div class="form-check" style="margin: auto;">
                                                            <input class="form-check-input" type="radio" name="assignment_type" id="formCheck-3" value="1" {{ ($task->assignment_type == 1) ? 'checked' : '' }} {{ ($task->assignment_type == 2) ? '' : 'checked' }}>
                                                            <label class="form-check-label" for="formCheck-3" >Auto Assignment</label></div>
                                                        <div class="form-check" style="margin: auto;">
                                                            <input class="form-check-input" type="radio" name="assignment_type" id="formCheck-4" value="2" {{ ($task->assignment_type == 2) ? 'checked' : '' }} {{ ($task->assignment_type == 1) ? '' : 'checked' }}>
                                                            <label class="form-check-label" for="formCheck-4">Urgent</label></div>
                                                    </div>
                                                </div>
                                                <div class="col" style="margin: 1em;">
                                                    <div><label class="form-label"><strong>Tasks to be done</strong> (optional)</label></div>
                                                    <div class="d-xl-flex align-items-xl-center">
                                                        <input name="to_be_done" type="text" style="width: 20em;height: 5em;" placeholder="{{$task->to_be_done}}"></div>
                                                </div>
                                                <div class="col" style="margin: 1em;">
                                                    <div><label class="form-label"><strong>Note </strong>(contact person, what to bring, etc.)</label></div>
                                                    <div class="d-xl-flex align-items-xl-center">
                                                        <input name="note" type="text" style="width: 20em;height: 5em;" placeholder="{{$task->note}}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer d-xl-flex justify-content-xl-center">
                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" style="background: rgb(248,190,91);color: rgb(0,0,0);border-style: none;">Edit Task</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>