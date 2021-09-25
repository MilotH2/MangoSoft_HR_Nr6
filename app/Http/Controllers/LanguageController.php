<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Validator;

class LanguageController extends Controller
{
    public function index(){
        $languages = Language::where('contact_id',request('contact_id'))->get();
        return response()->json($languages);
    }
    public function store(){

        $valid = Validator::make(request()->all(), [
            'contact_id'=>'required',
            'language'  =>'required',
            'level'     =>'required',
        ]);
        if($valid->errors()->messages()!=null){
            return response()->json($valid->errors());
        }
        $language = new Language();
        $language->contact_id   = request('contact_id');
        $language->language     = request('language');
        $language->level        = request('level');
        $language->save();

        return response()->json($language);
    }
    public function destroy(){
        $language = Language::where('contact_id',request('contact_id'))->where('id',request('language_id'))->first();
        $language->delete();
        return $this->index();
    }
}
