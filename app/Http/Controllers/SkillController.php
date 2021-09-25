<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Validator;

class SkillController extends Controller
{
    public function __allSkill(){
        $skills = Skill::distinct()->get('skill');
        return response()->json($skills);
    }
    public function index(){
        $skills = Skill::where('contact_id',request('contact_id'))->get();
        return response()->json($skills);
    }
    public function store(){

        $valid = Validator::make(request()->all(), [
            'contact_id' =>'required',
            'skill'=>'required',
            'level'=>'required'
        ]);
        if($valid->errors()->messages()!=null){
            return response()->json($valid->errors());
        }
        $skill = new Skill();
        $skill->contact_id  = request('contact_id');
        $skill->skill       = request('skill');
        $skill->level       = request('level');
        $skill->save();

        return response()->json($skill);
    }
    public function destroy(){
        $skill = Skill::where('contact_id',request('contact_id'))->where('id',request('skill_id'))->first();
        $skill->delete();
        return $this->index();
    }
}
