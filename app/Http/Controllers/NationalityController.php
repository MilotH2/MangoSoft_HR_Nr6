<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use Validator;

class NationalityController extends Controller
{
    public function index(){
        $nationalities = Nationality::where('contact_id',request('contact_id'))->get();
        return response()->json($nationalities);
    }
    public function store(){

        $valid = Validator::make(request()->all(), [
            'contact_id'        =>'required',
            'nationality'       =>'required',
            'permission_to_work'=>'required',
        ]);
        if($valid->errors()->messages()!=null){
            return response()->json($valid->errors());
        }
        $nationality = new Nationality();
        $nationality->contact_id            = request('contact_id');
        $nationality->nationality           = request('nationality');
        $nationality->permission_to_work    = request('permission_to_work');
        $nationality->save();

        return response()->json($nationality);
    }
    public function destroy(){
        $nationality = Nationality::where('contact_id',request('contact_id'))->where('id',request('nation_id'))->first();
        $nationality->delete();
        return $this->index();
    }
}
