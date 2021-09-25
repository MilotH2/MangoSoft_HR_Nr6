<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Validator;

class DegreeController extends Controller
{
    public function index(){
        $degrees = Degree::where('contact_id',request('contact_id'))->get();
        return response()->json($degrees);
    }
    public function store(){

        $valid = Validator::make(request()->all(), [
            'contact_id' =>'required',
            'degree'=>'required',
            'year'=>'required',
            'institution'=>'required',
        ]);
        if($valid->errors()->messages()!=null){
            return response()->json($valid->errors());
        }
        $degree = new Degree();
        $degree->contact_id     = request('contact_id');
        $degree->degree         = request('degree');
        $degree->finished_year  = request('year');
        $degree->institution    = request('institution');
        $degree->save();

        return response()->json($degree);
    }
    public function destroy(){
        $degree = Degree::where('contact_id',request('contact_id'))->where('id',request('degree_id'))->first();
        $degree->delete();
        return $this->index();
    }
}
