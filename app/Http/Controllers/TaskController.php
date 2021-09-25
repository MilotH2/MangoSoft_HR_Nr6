<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class TaskController extends Controller
{
    public function getTasksForKanbanFunction(){
        $user = User::where('remember_token',\request('token'))->first();
        $tasks = Task::where('user_id',$user->id)->orderBy('id','DESC')->where('status','<=',4)->where('status','>',0)->with('contact')->with('assigned_user')->get();
        $tmpData = [];
        foreach ($tasks as $task){
            if ($task->status == 1){
                $status = 'Requested';
            }else if($task->status == 2){
                $status = 'Prepared';
            }else if($task->status == 3){
                $status = 'Checked';
            }else if($task->status == 4){
                $status = 'Status-Open';
            }else{
                $status = '';
            }
            $tmpData[] = [
                'id' => $task->id,
                'status'=>$status,
                'description'=>$task->description,
                'contact'=>$task->contact,
                'company'=>$task->company,
                'link'=>$task->link,
                'administrator'=>$task->assigned_user,
            ];
        }
        return $tmpData;
    }

    public function getTasksForKanban(){
//        $user = $this->checkToken(request('token'));
        $tmpData = self::getTasksForKanbanFunction();
        //$tasks = Task::with('assigned_employee')->with('comments')->whereProjectId(request('id'))->latest();
        return response()->json($tmpData);
        //return $this->returnData(true, null, $tmpData);
    }

    public function updateTaskStatus(){
        try{
            DB::beginTransaction();

            $task = Task::find(request('task_id'));
            //dd($task->status);
            $tmpStatus = \request('status');
            //dd($tmpStatus);
            if ($task->status == 4  && $tmpStatus  != 'Status-Open' ){
                $tmpStatuses = Status::where('task_id',$task->id)->first();
                $tmpStatuses->status =0;
                $tmpStatuses->save();
            }
            if (request('status') == 'Requested'){
                $task->status = 1;
            }else if (request('status') == 'Prepared'){
                $task->status = 2;
            }else if (request('status') == 'Checked'){
                $task->status = 3;
            }else if (request('status') == 'Status-Open'){
                $task->status = 4;
            }
            $task->save();
            if ($task->status == 4){
                $status = new Status();
                $status->task_id = $task->id;
                $status->status = 1;
                $status->save();
            }
            if ($task->status == 1){
                $tmpStatus2 = 'Requested';
            }elseif ($task->status ==2){
                $tmpStatus2 = 'Prepared';
            }elseif ($task->status ==3){
                $tmpStatus2 = 'Checked';
            }elseif ($status->status ==4) {
                $tmpStatus2 = 'Status-Open';
            }else{
                $tmpStatus2 = '';
            }
            $contact_id = $task->contact_id;
            $description = 'Task with description' .' ' .$task->description .' has been changed from'. ' '.$tmpStatus2 .' '. 'to'.' '. \request('status');
            ActivityController::__storeActivity($contact_id,$description,'Task Update');
            $tmpData = self::getTasksForKanbanFunction();
            DB::commit();
            return response()->json($tmpData);
        }catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return false;
        }

    }
    public function deleteTask(){
        $task = Task::findOrFail(\request('id'));
        $task->status = 0;
        $task->save();
        $tmpData = self::getTasksForKanbanFunction();
        return response()->json($tmpData);
    }
    public function getAdministrators(){
        $administrators = User::where("role","!=",1)->get();
        return response()->json($administrators);
    }
    public function assignAdministrator(){
        $task = Task::where('id',\request('task_id'))->first();
        $task->assigned_user_id = \request('administrator');
        $task->save();
        $tmpData = self::getTasksForKanbanFunction();
        return response()->json($tmpData);
    }

//    public function addColumn(){
//        dd(\request()->all());
//    }
    public function tasks(){
        $user = auth()->user();
        $tasks = Task::where('user_id',$user->id)->get();
        return view('src.tasks.tasks',compact('tasks'));
    }
    public function __createTask(){
//        {{ dd(request()->all()) }}
        $valid = Validator::make(request()->all(), [
            'contact_id' =>'required',
        ]);
        if($valid->errors()->messages()!=null){
            return response()->json($valid->errors());
        }

        $user = auth()->user();
        $task = new Task();
        $task->user_id = $user->id;
        $task->contact_id = request('contact_id');
        $task->company = request('company');
        $task->description = request('description');
        $task->link = request('link');
        $task->status = 1; // requested
        $task->save();

        $task = Task::whereId($task->id)->with('contact')->first();


        $description ='For contact '. $task->contact->firstname .' '. $task->contact->lastname .' is created a task in the company:'.$task->company;
        ActivityController::__storeActivity(\request('contact_id'),$description,'Task created');
        return redirect('/search')->with("success","Task created successfully");
        // Task Status 1 requested
        // Task Status 2 prepared
        //  Task Status 3 checked
        // Task Status 4 status open (in this status tasks goes as status not as task, and then there are another statuses)
        // Status 5
        // Status 6
        // Status 7
    }


    public function delete($id){
        $task = Task::find($id);
        $task->delete();
    }
    public function deleteStatus($id){
        $status = Status::find($id);
        $status->delete();

    }
}
