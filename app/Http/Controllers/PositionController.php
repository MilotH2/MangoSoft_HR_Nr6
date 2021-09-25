<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Validator;

class PositionController extends Controller
{

    public function index(){
        $positions = Position::where('contact_id',request('contact_id'))->get();
        return response()->json($positions);
    }
    public function store(){

        $valid = Validator::make(request()->all(), [
            'contact_id' =>'required',
            'position'=>'required',
            'company'=>'required',
            'from_year'=>'required',
            'to_year'=>'required',
        ]);
        if($valid->errors()->messages()!=null){
            return response()->json($valid->errors());
        }
        $position = new Position();
        $position->contact_id  = request('contact_id');
        $position->position    = request('position');
        $position->company     = request('company');
        $position->from_year   = request('from_year');
        $position->to_year     = request('to_year');
        $position->description = request('description');
        $position->save();

        return response()->json($position);
    }
    public function destroy(){
        $position = Position::where('contact_id',request('contact_id'))->where('id',request('position_id'))->first();
        $position->delete();
        return $this->index();
    }
}
