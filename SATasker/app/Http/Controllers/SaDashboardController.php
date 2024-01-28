<?php

namespace App\Http\Controllers;

use App\Models\SaProfile;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;  
use App\Models\UserTask;
use App\Models\SaTaskTimeLog;
use App\Models\User;
use Carbon\Carbon;

class SaDashboardController extends Controller
{
    //

    public function index(){
        $user = $this->getuserID();
        $urgentTasks = DB::table('tasks')
        //->join('user_tasks','user_tasks.task_id','tasks.id')
        ->where('assignment_type', 2)
        //->where('user_tasks.task_status_id','=',1)
        //->select('tasks.id')
        ->orderby('tasks.id', 'asc')->paginate(3);

        $assignedTasks = DB::table('user_tasks')
        ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
        ->join('users', 'user_tasks.user_id', '=', 'users.id')
        ->where('users.id', $user->id)
        ->where('task_status_id',1)
        ->select('user_tasks.id','tasks.id AS task_id','tasks.start_date','tasks.start_time','tasks.end_time','tasks.preffred_program','users.email' , 'tasks.to_be_done', 'tasks.assigned_office', 'tasks.note')
        ->orderby('user_tasks.id', 'asc')->paginate(5);    
        return view('sa.sa_dashboard', compact('urgentTasks','assignedTasks','user'));
    }

    public function getuserID()
    {
        //
        $user_id = session('user_id');
        $user = User::find($user_id);
        return $user;
    }

    public  function acceptTask($id){
        $user = $this->getuserID();
        $task = Task::find($id);
        $userTask = new UserTask();
        $userTask->user_id = $user->id;
        $userTask->task_id = $task->id;
        $userTask->task_status_id = 1;
        $userTask->save();

        session()->flash('accept_task_success', 'Task accepted successfully!');
        return redirect()->route('sa.dashboard');
    }

    public function saCounter($num_sa,$task)
    {
        $saCount = DB::table('user_tasks')
        ->where('task_id',$task->id)
        ->where('task_status_id',1)
        ->count();
        
        return $saCount;
    }

    public function profile(){
        $user = $this->getuserID();
        $userProfiles = SaProfile::where('user_id', $user->id_number)->get();
        $taskHistory = DB::table('user_tasks')
        ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
        ->join('users', 'user_tasks.user_id', '=', 'users.id')
        ->where('users.id', $user->id)
        ->select('tasks.id','tasks.start_date','tasks.preffred_program', 'tasks.to_be_done', 'tasks.assigned_office', 'tasks.note', 'user_tasks.hours_rendered', 'user_tasks.feedback')
        ->orderby('user_tasks.id', 'asc')->paginate(5);
        return view('sa.sa_profile', compact('user','userProfiles', 'taskHistory'));
    }

    public function addTimeIn(Request $request)
    {
        $taskId = $request->input('task_id');
        $userId = $request->input('user_id');
        $timein = now();

        $timeLog = SaTaskTimeLog::where('task_id', $taskId)
                                ->where('user_id', $userId)
                                ->whereDate('time_in', $timein->toDateString())
                                ->first();

        if (!$timeLog) {
            
            $timeLog = new SaTaskTimeLog;
            $timeLog->task_id = $taskId;
            $timeLog->user_id = $userId;
            $timeLog->time_in = $timein;
            $timeLog->total_hours = 0;
            $timeLog->is_Approved_In = 'Pending'; 
            $timeLog->save();

            return redirect()->back()->with('success', 'Time-in logged successfully, awaiting approval.');
        } else {
            return redirect()->back()->with('warning', 'Time-in already exists for this task and date.');
        }
    }

    public function addTimeOut(Request $request)
{
    $taskId = $request->input('task_id');
    $userId = $request->input('user_id');
    $timeout = now();

    $timeLog = SaTaskTimeLog::where('task_id', $taskId)
        ->where('user_id', $userId)
        ->whereDate('time_in', $timeout->toDateString())
        ->whereNull('time_out')
        ->where('time_in', '<=', $timeout->subMinutes(30)) // Enforce 30-minute rule
        ->first();

    if ($timeLog) {
        $timeOutCarbon = Carbon::parse($timeout);
        $timeInCarbon = Carbon::parse($timeLog->time_in);

        $totalHours = number_format($timeOutCarbon->diffInSeconds($timeInCarbon) / 3600, 2);

        $timeLog->time_out = $timeout;
        $timeLog->total_hours = $totalHours;
        $timeLog->is_Approved_out = 'Pending';
        $timeLog->save();

        return redirect()->back()->with('success', 'Time-out logged successfully, awaiting approval.');
    } else {
        return redirect()->back()->with('error', 'No matching time-in record found or time-in is less than 30 minutes ago.');
    }
}
}
