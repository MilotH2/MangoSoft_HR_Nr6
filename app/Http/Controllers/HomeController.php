<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Skill;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;
use MongoDB\Driver\Query;

class HomeController extends Controller
{
    public $q, $lastCondition;
    public $attempt = 0;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard(){
        $contacts = Contact::count();
        $activeTasks = Task::where('status','>',0)->count();
        $tasks = Task::count();
        $statuses = Status::count();
        $contracts = Status::where('status',6)->count();
        $opens = Status::where('status',1)->count();
        $declines = Status::where('status',5)->count();
        $interviews = Status::whereIn('status',[2,3,4])->count();
        $lastContacts = Contact::with('positions')->latest()->limit(5)->get();
        return view('src.dashboard',compact('contacts','tasks','activeTasks','statuses','contracts','opens','declines','interviews','lastContacts'));
    }
    public function filterSearch(){
        //$this->searchString = strtolower('Java or test');
        //$s = strtolower('Java and (test or test2)');
        $s = 'PHP or (Java and Vue)';
        //$s = 'Java and (php or javascript) and (Python or Ruby)';
       // $s = strtolower('Java or test');
        //$q = new Skill();

        $contacts = Contact::where('firstname','like','%Leotrin%')->whereHas('skills',function($q) use ($s){
            $this->__search($q, $s);
        })->with('skills')->get();
//        foreach ($contacts as $key=>$c){
//            $contacts[$key] = $c->skills()->where(function($q) use ($s){
//                $this->__search($q, $s);
//            });
//        }
       // dd($contacts->skills());

        dd($contacts);
//        $this->q = new Skill();
//
//        dd($this->__search($this->q, $s)->groupBy('contact_id')->get());

//        dd();
    }
    public function __search($q, $s){
        $this->attempt +=1;

        $conditionAnd = strpos($s, 'and');
        $conditionOr = strpos($s, 'or');
        if (strpos($s, '(') === false) {
            if ($conditionAnd == false && $conditionOr == false) {
                $q = $q->where('skill',$s);
            } elseif ($conditionAnd == false && $conditionOr != false) {
                $conditionOrs = explode('or', $s);

                if($this->lastCondition == 'or') {
                    $q = $q->orWhereHas('skillRelated',function ($e) use ($conditionOrs){
                        foreach ($conditionOrs as $key=>$or) {
                            if($key==0){
                                $e->where('skill','like','%'.str_replace(' ',  '', $or).'%');
                            }else{
                                $e->orWhere('skill','like','%'.str_replace(' ',  '', $or).'%');

                            }
                        }
                    });
                }else{
                    $q = $q->whereHas('skillRelated',function ($e) use ($conditionOrs){
                        foreach ($conditionOrs as $key=>$or) {
                            if($key==0){
                                $e->where('skill','like','%'.str_replace(' ',  '', $or).'%');
                            }else{
                                $e->orWhere('skill','like','%'.str_replace(' ',  '', $or).'%');

                            }
                        }
                    });
                }
                return $q;
            } elseif ($conditionAnd != false && $conditionOr == false) {
                $conditionAnds = explode('and', $s);
                if($this->lastCondition == 'or') {
                    $q = $q->orWhereHas('skillRelated', function ($e) use ($conditionAnds) {
                        foreach ($conditionAnds as $and) {
                            $e->where('skill', 'like', '%' . str_replace(' ', '', $and) . '%');
                        }
                    });
                }else{
                    $q = $q->whereHas('skillRelated', function ($e) use ($conditionAnds) {
                        foreach ($conditionAnds as $and) {
                            $e->where('skill', 'like', '%' . str_replace(' ', '', $and) . '%');
                        }
                    });
                }
            }
        }else{
            $filter = $this->__getBetween($s);
            $condition = $this->__getValueAndCondition($filter['condition']);
            $sx =  $filter['string'];
//            if($this->attempt == 2){
//                dd($filter);
//            }


            if($condition != false) {
                if ($condition['condition'] == 'or') {
                    if($this->lastCondition == 'or') {
                        $q = $q->orWhereHas('skillRelated',function ($e) use ($condition, $sx) {
                            $e->where('skill','like','%'.str_replace(' ',  '', $condition['string']).'%');
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__search($e, $sx);
                        });
                    }else{
                        $q = $q->whereHas('skillRelated',function ($e) use ($condition, $sx) {
                            $e->where('skill','like','%'.str_replace(' ',  '', $condition['string']).'%');
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__search($e, $sx);
                        });
                    }
                }
                if ($condition['condition'] == 'and') {
                    if($this->lastCondition == 'or') {
                        $q = $q->orWhereHas('skillRelated',function ($e) use ($condition, $sx) {
                            $e->where('skill','like', '%'.str_replace(' ',  '', $condition['string']).'%');
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__search($e, $sx);
                        });
                    }else{
                        $q = $q->whereHas('skillRelated',function ($e) use ($condition, $sx) {
                            $e->where('skill','like', '%'.str_replace(' ',  '', $condition['string']).'%');
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__search($e, $sx);
                        });
                    }
                }
            }
            return $q;
        }
    }
    public function __getBetween($s){
//        $newString = null;
//        $found = 0; $start = -1; $end = -1;
//        for($i=0; $i<strlen($s); $i++){
//            if($s[$i] == '(' ){
//                if($found == 0){
//                    $start = $i;
//                }
//                $found++;
//            }
//
//            if($s[$i] == ')'){
//                $found--;
//                $end = $i;
//
//                if($start > -1 && $end > 0 && $found == 0){
//                    $newString = substr($s, $start+1, (($end-$start)-1));
//
//                }
//            }
//        }
//        if($newString!=null){
//            $firstCondition = substr($s, 0, $start)  . substr($s, $end+1, strlen($s));;
//            return ['string'=>$newString, 'condition'=>$firstCondition];
//        }
//        return false;
        $start = strpos($s,'(');
        $end = strrpos($s,')');
        $newString = substr($s,$start+1, ($end-$start)-1);
        $firstCondition = substr($s, 0, $start)  . substr($s, $end+1, strlen($s));;
        return ['string'=>$newString, 'condition'=>$firstCondition];
    }
    public function __addCV($condition){
        $first = explode('and', $condition);
        if(isset($first[1]) && $first[1] != null){
            //$this->lastCondition ='and';
            if(isset($first[1]) && $first[1] != ' '){
                return ['string'=>$first[1], 'condition'=>'and'];
            }
            return ['string'=>$first[0], 'condition'=>'and'];

        }elseif(explode('or', $condition) != null){
            //$this->lastCondition ='or';
            $first = explode('or',$condition);
            if(isset($first[1]) && $first[1] != ' '){
                return ['string'=>$first[1], 'condition'=>'or'];
            }
            return ['string'=>$first[0], 'condition'=>'or'];
        }else{
            return false;
        }

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

}
