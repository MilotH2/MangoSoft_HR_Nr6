<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function statuses(){
        $statuses = Status::with('task')->get();
        return view('src.statuses.statuses',compact('statuses'));
    }

    public function getStatusesForKanbanFunction(){
        $user = User::where('remember_token',\request('token'))->first();
        $statuses = Status::whereHas('task', function($q) use ($user){
            $q->where('user_id',$user->id);
        })->whereNotIn('status',[0,7])->get();
        //status 7 archive status
        $tmpData = [];
        foreach ($statuses as $s){
            if ($s->status == 1){
                $status = 'Submitted';
            }else if($s->status == 2){
                $status = 'First-Interview';
            }else if($s->status == 3){
                $status = 'Second-Interview';
            }else if($s->status == 4){
                $status = 'Third-Interview';
            }else if($s->status == 5){
                $status = 'Decline';
            }else if($s->status == 6){
                $status = 'Contract';
            }else{
                $status = '';
            }
            $tmpData[] = [
                'id' => $s->id,
                'status'=>$status,
                'description'=>$s->task->description,
                'contact'=>$s->task->contact,
                'task'=>$s->task,
                'company'=>$s->task->company,
                'link'=>$s->task->link,
            ];
        }
        return $tmpData;
    }

    public function archive(){
        $user = User::where('remember_token',\request('token'))->first();
        $status = Status::whereId(request('status_id'))->with('task')->first();
        $status->status = 7; //archive status
        $status->save();

        $description = 'Status with description' .' ' .$status->task->description .' has been archived';
        $contact_id = $status->task->contact_id;
        ActivityController::__storeActivity($contact_id,$description,'Status Update');

        $tmpData = self::getStatusesForKanbanFunction();
        return response()->json($tmpData);

    }

    public function getStatusesForKanban(){
//        $user = $this->checkToken(request('token'));
        $tmpData = self::getStatusesForKanbanFunction();
        //$tasks = Task::with('assigned_employee')->with('comments')->whereProjectId(request('id'))->latest();
        return response()->json($tmpData);
        //return $this->returnData(true, null, $tmpData);
    }

    public function updateStatuses(){
        $status = Status::whereId(request('status_id'))->with('task')->first();
        if (request('status') == 'Submitted'){
            $status->status = 1;
        }else if (request('status') == 'First-Interview'){
            $status->status = 2;
        }else if (request('status') == 'Second-Interview'){
            $status->status = 3;
        }else if (request('status') == 'Third-Interview'){
            $status->status = 4;
        }else if (request('status') == 'Decline'){
            $status->status = 5;
            $task = Task::find($status->task_id);
            $task->status = 5;
            $task->save();
        }else if (request('status') == 'Contract'){
            $status->status = 6;
            $task = Task::find($status->task_id);
            $task->status = 5;
            $task->save();
        }
        $status->save();
        $contact_id = $status->task->contact_id;
        if ($status->status == 1){
            $tmpStatus = 'Submitted';
        }elseif ($status->status ==2){
            $tmpStatus = 'First-Interview';
        }elseif ($status->status ==3){
            $tmpStatus = 'Second-Interview';
        }elseif ($status->status ==4){
            $tmpStatus = 'Third-Interview';
        }elseif ($status->status ==5){
            $tmpStatus = 'Decline';
        }elseif ($status->status ==6){
            $tmpStatus = 'Contract';
        }else{
            $tmpStatus = '';
        }
        $description = 'Status with description' .' ' .$status->task->description .' has been changed from'. ' '.$tmpStatus .' '. 'to'.' '. \request('status');
        ActivityController::__storeActivity($contact_id,$description,'Status Update');


        $tmpData = self::getStatusesForKanbanFunction();
        return response()->json($tmpData);
    }


}
