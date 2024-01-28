<?php

namespace App\Http\Controllers;

use App\Models\SaTaskTimeLog;
use App\Models\UserTask;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\CoursesTable;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;  


class OfficeAdminDashboardController extends Controller
{
    
    
    /**
     * Display a listing of the resource.
     */
    //View all tasks - not used
     public function index()
    {
        $tasks = Task::all();
        return view('office.office_dashboard', compact('tasks'));
    }

    public function program()
    {
        $program = CoursesTable::where('is_offered',true)->get();
        return $program;
    }

    //view active tasks
    public function active()
    {
        //$tasks = Task::all();
        $courses = $this->program();
        $user = $this->getuserID();
        $tasks = Task::where('isActive', true)->get();
        
        return view('office.office_dashboard_active', compact('tasks','user','courses'));
    }

    //view inactive tasks

    public function inactive()
    {
        //$tasks = Task::all();
        $courses = $this->program();
        $user = $this->getuserID();
        $tasks = Task::where('isActive', false)->get();
        return view('office.office_dashboard_inactive', compact('user','tasks','courses'));
    }

    public function taskView()
    {
        return view('office.office_task_review');
    }

    public function getuserID()
    {
        $user_id = session('user_id');
        $user = User::find($user_id);
        return $user;
    }

    public function saCounter($num_sa,$task)
    {
        $saCount = DB::table('user_tasks')
        ->where('task_id',$task->id)
        ->where('task_status_id',1)
        ->count();
        if ($saCount < $num_sa){
            session()->flash('add_task_success', 'Student Assistant full!!');
        }
    }
    
    public function taskSaList(Request $request)
    {
        $user = $this->getuserID();
        $taskId = $request->route('taskId');

        $saLists = User::join('user_tasks','users.id','=','user_tasks.user_id')
        ->join('tasks','user_tasks.task_id','=','tasks.id')
        ->join('sa_profiles','users.id_number','=','sa_profiles.user_id')
        ->leftJoin('user_tasks_timelog', function ($join) use ($taskId) {
            $join->on('user_tasks_timelog.task_id', '=', 'tasks.id')
                ->where('user_tasks_timelog.task_id', '=', $taskId); // Filter timelogs by taskId
        })
        ->select(
            'user_tasks_timelog.id AS timelogId',
            'sa_profiles.user_id',
            'sa_profiles.first_name',
            'sa_profiles.last_name',
            'sa_profiles.course_program',
            'tasks.start_date',
            DB::raw('DATE_FORMAT(user_tasks_timelog.time_in, "%H:%i") AS timein'), 
            DB::raw('DATE_FORMAT(user_tasks_timelog.time_out, "%H:%i") AS timeout')
        )
        ->where('tasks.id','=', $taskId)
        ->get();
       
        return view('office.salist_task', compact('saLists','user','taskId'));
    }

    public function addFeedback(Request $request)
    {   
        $timeLogId = $request->input('timelogId');
        $feedback = $request->input('feedback');

        // Retrieve the specific time log using first()
        $timeLog = SaTaskTimeLog::where('id', $timeLogId)->first();

        if ($timeLog) {
            $timeLog->feedback = $feedback;
            $timeLog->save();

            return redirect()->back()->with('success', 'Feedback saved successfully!');
        } else {
            // Handle the error case where a time log is not found
            return redirect()->back()->with('error', 'Time log not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $task = new Task();
        $task->preffred_program = $request->input('preffred_program');
        $task->start_date = $request->input('start_date');
        //$task->end_date = $request->input('end_date');
        $task->start_time = $request->input('start_time');
        $task->end_time = $request->input('end_time');
        $task->number_of_sa = $request->input('number_of_sa');
        $task->status = $request->input('status');
        $task->assignment_type = $request->input('assignment_type');
        $task->to_be_done = $request->input('to_be_done');
        $task->note = $request->input('note');
        $task->assigned_office = $request->input('assigned_office');
        $task->save();

        session()->flash('add_task_success', 'Task added successfully!');
        return redirect()->route('office.admin.active.dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $task = Task::findOrFail($id);

        $task->preffred_program = $request->input('preffred_program');
        $task->start_date = $request->input('start_date');
        //$task->end_date = $request->input('end_date');
        $task->number_of_sa = $request->input('number_of_sa');
        $task->status = $request->input('status');
        $task->assignment_type = $request->input('assignment_type');
        $task->to_be_done = $request->input('to_be_done');
        $task->note = $request->input('note');
        $task->assigned_office = $request->input('assigned_office');
        $task->save();
        
        session()->flash('edit_task_success', 'Task edited successfully!');
        //return redirect()->route('tasks.show', $task);
        return redirect()->route('office.admin.inactive.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(string $id)
    {
        //
        $task = Task::findOrFail($id);
        $task->isActive = false;
        $task->delete_at = now();
        $task->save();

        session()->flash('cancel_task_success', 'Task canceled successfully!');
        return redirect()->route('office.admin.inactive.dashboard');

    }
    public function delete(string $id)
    {
        //
        $task = Task::findOrFail($id);
        $task->delete();

        session()->flash('delete_task_success', 'Task deleted successfully!');
        return redirect()->route('office.admin.inactive.dashboard');

    }
}
