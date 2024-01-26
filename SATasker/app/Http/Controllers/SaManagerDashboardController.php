<?php

namespace App\Http\Controllers;

use App\Models\SaTaskTimeLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SaManagerDashboardController extends Controller
{
    //

    public function index(){
        return view('sam.sam_dashboard');
    }

    public function onGoing(){
        $assignedTasks = DB::table('user_tasks')
        ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
        ->join('users', 'user_tasks.user_id', '=', 'users.id')
        ->leftJoin('user_tasks_timelog', 'user_tasks_timelog.task_id', '=', 'user_tasks.task_id')
        ->where('tasks.isActive', 1)
        ->select('user_tasks.id', 'tasks.start_date', 'tasks.start_time', 'tasks.end_time', 'tasks.preffred_program', 'users.email', 'tasks.to_be_done', 'tasks.assigned_office', DB::raw('SUM(user_tasks_timelog.total_hours) as total_hours'), 'tasks.note') 
        ->groupBy('user_tasks.id', 'tasks.start_date', 'tasks.start_time', 'tasks.end_time', 'tasks.preffred_program', 'users.email', 'tasks.to_be_done', 'tasks.assigned_office', 'tasks.note') // Group by all non-aggregated columns
        ->orderBy('user_tasks.id', 'asc')
        ->paginate(5);  
        return view('sam.sam_dashboard_ongoing', compact('assignedTasks'));//,'user'
    }

    public function finished(){
        $assignedTasks = DB::table('user_tasks')
        ->join('tasks', 'user_tasks.task_id', '=', 'tasks.id')
        ->join('users', 'user_tasks.user_id', '=', 'users.id')
        ->leftJoin('user_tasks_timelog', 'user_tasks_timelog.task_id', '=', 'user_tasks.task_id')
        ->where('tasks.isActive', 0)
        ->select('user_tasks.id', 'tasks.start_date', 'tasks.start_time', 'tasks.end_time', 'tasks.preffred_program', 'users.email', 'tasks.to_be_done', 'tasks.assigned_office', DB::raw('SUM(user_tasks_timelog.total_hours) as total_hours'), 'tasks.note')
        ->groupBy('user_tasks.id', 'tasks.start_date', 'tasks.start_time', 'tasks.end_time', 'tasks.preffred_program', 'users.email', 'tasks.to_be_done', 'tasks.assigned_office', 'tasks.note') // Group by all non-aggregated columns
        ->orderBy('user_tasks.id', 'asc')
        ->paginate(5);
        return view('sam.sam_dashboard_done', compact('assignedTasks'));//,'user'
    }

    public function viewSaList(Request $request)
    {   
        $user_id = session('user_id');
        $user = User::find($user_id);
        $taskId = $request->route('taskId');

        $saLists = User::join('user_tasks','users.id','=','user_tasks.user_id')
        ->join('tasks','user_tasks.task_id','=','tasks.id')
        ->join('sa_profiles','users.id_number','=','sa_profiles.user_id')
        ->leftJoin('user_tasks_timelog', function ($join) {
            $join->on('user_tasks_timelog.task_id', '=', 'tasks.id')
                ->on('user_tasks_timelog.user_id', '=', 'users.id');
        })
        ->select(
            'sa_profiles.user_id',
            'sa_profiles.first_name',
            'sa_profiles.last_name',
            'sa_profiles.course_program',
            'user_tasks_timelog.id AS timelogId',
            DB::raw('DATE_FORMAT(user_tasks_timelog.time_in, "%H:%i") AS timein'), 
            DB::raw('DATE_FORMAT(user_tasks_timelog.time_out, "%H:%i") AS timeout'),
            'user_tasks_timelog.total_hours' 
        )
        ->where('tasks.id','=', $taskId)
        ->get();
       
        return view('sam.sam_salist_task_ongoing', compact('saLists','user','taskId'));
    }

    public function viewSaListDone(Request $request)
    {   
        $user_id = session('user_id');
        $user = User::find($user_id);
        $taskId = $request->route('taskId');

        $saLists = User::join('user_tasks','users.id','=','user_tasks.user_id')
        ->join('tasks','user_tasks.task_id','=','tasks.id')
        ->join('sa_profiles','users.id_number','=','sa_profiles.user_id')
        ->leftJoin('user_tasks_timelog', function ($join) {
            $join->on('user_tasks_timelog.task_id', '=', 'tasks.id')
                ->on('user_tasks_timelog.user_id', '=', 'users.id');
        })
        ->select(
            'sa_profiles.user_id',
            'sa_profiles.first_name',
            'sa_profiles.last_name',
            'sa_profiles.course_program',
            'user_tasks_timelog.id AS timelogId',
            DB::raw('DATE_FORMAT(user_tasks_timelog.time_in, "%H:%i") AS timein'), 
            DB::raw('DATE_FORMAT(user_tasks_timelog.time_out, "%H:%i") AS timeout'),
            'user_tasks_timelog.total_hours' 
        )
        ->where('tasks.id','=', $taskId)
        ->get();
       
        return view('sam.sam_salist_task_done', compact('saLists','user','taskId'));
    }

    public function addHours(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'add_hours' => 'required|numeric|min:0',
        ]);

        // Get the existing total_hours value from the timelog or set a default of 0
        $existingTotalHours = 0;
        $timeLog = SaTaskTimeLog::where('id', $request->timelog_id)->first();
        if ($timeLog) {
            $existingTotalHours = $timeLog->total_hours;
        }

        // Calculate the new total_hours
        $newTotalHours = $existingTotalHours + $request->add_hours;

        // Update the timelog or create a new one if it doesn't exist
        
        $timeLog->total_hours = $newTotalHours;
        $timeLog->save();

        // Redirect to a success page or display a success message
        return redirect()->back()->with('success', $request->add_hours.' Hour/s added successfully!');
    }

}
