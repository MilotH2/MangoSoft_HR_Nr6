<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    static function __storeActivity($contact_id,$description,$type){
        $activity = new Activity();
        $activity->contact_id = $contact_id;
        $activity->description = $description;
        $activity->type = $type;
        $activity->save();
        return $activity;
    }
    public function __storeNote(){
        $activity = Activity::find(\request('activity_id'));
        $activity->note = \request('activity_note');
        $activity->save();


        return redirect("contact/activities/$activity->contact_id");


    }
}
