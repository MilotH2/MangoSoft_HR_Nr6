<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Position;
use DB;
use Stevebauman\Location\Location;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public $q, $lastCondition;
    public $attempt = 0;

    public function index(){
        $contactsCount = Contact::count();
        $contacts = Contact::with('activities')->latest()->paginate(100);
        return view('src.contacts.list',compact('contacts','contactsCount'));
    }

    public function show($id=null){

        $url = URL::current();
        $isStart = false;
        if (STR::contains($url, 'start')) {
            $isStart = true;
        }
//        dd($isStart);
        $contact = new Contact();
        if($id!=null){
            //$contact = Contact::findOrFail($id);
            $contact = Contact::where('id',$id)->with('notes')->first();
            if ($contact == null){
                return redirect()->back()->with('error','Contact not found');
            }
        }
        return view('src.contacts.form',compact('contact', 'isStart'));
    }

    public function __storeContact(){
        request()->validate( [
            'firstname' =>'required',
            'lastname'=>'required',
            'email'=>'required',
            'mobile'=>'required'
        ]);

        if(request()->has('id')  && request('id')!=null){
            $contact = Contact::find(request('id'));
            if($contact==null){
                return back()->with("errors","Contact not found!");
            }
        }else{
            $contact = new Contact();
        }
        $contact->firstname     = request('firstname');
        $contact->lastname      = request('lastname');
        $contact->email         = request('email');
        $contact->mobile        = request('mobile');
        $contact->tel           = request('tel');
        $contact->plz           = request('plz');
        $contact->location      = request('location');
        $contact->country       = request('country');
        $contact->birthday      = request('birthday');
        $contact->link_to_pdf   = request('link_to_pdf');
        $contact->salary_from   = request('salary_from');
        $contact->salary_to     = request('salary_to');

        $string = $contact->location."".$contact->plz ."". $contact->country;
        $string = str_replace(' ', '', $string);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$string&key=AIzaSyBYU0AHeiV6cYQM3JSi-_rDjJX9LTmi4CY";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resultURL = curl_exec($ch);
        $data = json_decode($resultURL,true);
        if($data != null && $data["status"] == "OK"){
            $lat = $data["results"][0]["geometry"]["location"]["lat"];
            $lng = $data["results"][0]["geometry"]["location"]["lng"];
            $contact->latitude = $lat;
            $contact->longitude = $lng;
        }
        $contact->freelancer    = 0;
        $contact->permanent     = 0;
        $contact->note     = request('note');
        if(request()->has('freelancer')) {
            $contact->freelancer = 1;
        }
        if(request()->has('permanent')) {
            $contact->permanent = 1;
        }

        $contact->save();
        return redirect('/contact/update/'.$contact->id)->with("success","Contact saved successfully");

    }
    public function __generalSearch(){
        $search = request('search');
        $s = explode(' ',$search);
        $searchResults = Contact::where('firstname','like','%'.$s[0].'%')
            ->where(function($q) use($s){
                if(isset($s[1])){
                    $q->where('lastname','like','%'.$s[1].'%');
                }
            })
            ->latest()->paginate(100);
        return view('src.search',compact('searchResults', 'search'));
    }
    public function __search(){
        $degrees = ['High School','Efz','Fachausweis','Diplom','Höhere Fachschule','Cas','Mas','Bachelor','Master','Phd'];
        $positions = Position::distinct()->get('position');
        $languages = Language::select('*', DB::raw('count(language) AS nrs'))->groupBy('language')->orderBy('language', 'asc')->get();
        $levels =['A1','A2','B1','B2','C1','native'];

        $filterDegrees = $degrees;
        $filterLevels = $levels;
        $searchDegree = request('degree');
        $searchLevel = request('level');
        $ip = request()->ip();
        if($ip!='127.0.0.1'){
            $locData = (new Location())->get($ip);
        }
        if (session()->has("radius")) $radius = session()->get("radius"); else $radius = null;
        if (session()->has("location")) $location = session()->get("location"); else $location = null;
        if (session()->has("skills")) $skills = session()->get("skills"); else $skills = null;
        if (session()->has("content")) $content = session()->get("content"); else $content = null;
        if (session()->has("searchDegree")) $searchDegree = session()->get("searchDegree"); else $searchDegree = null;
        if (session()->has("language")) $language = session()->get("language"); else $language = null;
        if (session()->has("permanent")) $permanent = session()->get("permanent"); else $permanent = null;
        if (session()->has("freelancer")) $freelancer = session()->get("freelancer"); else $freelancer = null;
        if (session()->has("level")) $level = session()->get("level"); else $level = null;

            if(request()->isMethod('post')) {
                if (request('degree') != '*' && request('degree') != null) {
                    $filterDegrees = array_slice($degrees, array_search(request('degree'), $degrees));
                    session()->put("searchDegree",request('degree'));
                }else{
                    if(session()->has("searchDegree"))
                        session()->remove("searchDegree");
                }
                if (request('level') != '*' && request('level') != null) {
                    $filterLevels = array_slice($levels, array_search(request('level'), $filterLevels));
                    session()->put("level",request('level'));
                }else{
                    if(session()->has("level"))
                        session()->remove("level");
                }

                if (request('location') != null) {
                    $location = explode(',',request('location'));
                    session()->put("location",$location[0]);}else{
                    if(session()->has("location"))
                        session()->remove("location");
                }
                if (request('content') != null) {session()->put("content",request('content'));}else{
                    if(session()->has("content"))
                        session()->remove("content");
                }
                if (request('skills') != null) {session()->put("skills",request('skills'));}else {
                    if (session()->has("skills"))
                        session()->remove("skills");
                }
                if (request('radius') != null) {session()->put("radius",request('radius'));}else{
                    if(session()->has("radius"))
                        session()->remove("radius");
                }
                if (request('language') != null) {session()->put("language",request('language'));}else{
                    if(session()->has("language"))
                        session()->remove("language");
                }

                if (request('permanent') != null) {session()->put("permanent",1);}else{
                    if(session()->has("permanent"))
                        session()->remove("permanent");
                }
                if (request('freelancer') != null) {session()->put("freelancer",1);}else{
                    if(session()->has("freelancer"))
                        session()->remove("freelancer");
                }
                session()->put("searched",true);
                return redirect("/search");
            }
            if(!session()->has("searched")){
                $contacts = Contact::latest()->paginate(250);
                //$contacts = $contacts->toArray();
            } else {
                $contacts = Contact::query();
                $contacts =  $contacts->with('positions')->with('degrees');
                $contacts = $contacts->where(function ($q) use ($content) {
                    if ($content != null) {
                        $content = explode(' ', $content);
                        $q->where('firstname', 'like', '%' . $content[0] . '%')->where(function ($query) use ($content) {
                            if (isset($content[1])) {
                                $query->where('lastname', 'like', '%' . $content[1] . '%');
                            }
                        });
                    }
                });

                if (request('degree') != '*' && request('degree') != null) {
                    $contacts = $contacts->whereHas('degrees', function ($q) use ($searchDegree, $filterDegrees, $degrees) {
                        if ($searchDegree != '*') {
                            if ($searchDegree != '*' && $searchDegree != null) {
                                $filterDegrees = array_slice($degrees, array_search($searchDegree, $degrees));
                            }
                            $q->whereIn('degree', $filterDegrees);
                        }
                    });
                }
                if (request('skills') != null) {
                    $contacts = $contacts->whereHas('skills', function ($q) use ($skills) {
                        if ($skills != null) {
                            $this->__skillsSearch($q, $skills);
                        }
                    });
                }
                if (request('permanent') != null) {
                    $contacts = $contacts->where(function ($q) use ($permanent) {
                        if ($permanent != null && $permanent == 1) {
                            $q->where('permanent', $permanent);
                        }
                    });
                }
                if (request('freelancer') != null) {
                    $contacts = $contacts->where(function ($q) use ($freelancer) {
                        if ($freelancer != null && $freelancer == 1) {
                            $q->where('freelancer', $freelancer);
                        }
                    });
                }
                if (request('language') != null) {
                    $contacts = $contacts->whereHas('languages', function ($q) use ($language, $filterLevels) {
                        if ($language != '*' && $language != null) {
                            $q->where('language', $language)->whereIn('level', $filterLevels);
                        }
                    });
                }
                if (request('location') != null) {
                    $contacts = $contacts->whereHas('contactData', function ($q) use ($location, $radius, $locData) {
                        if ($radius != null) {
                            if ($location == null && $locData != false)
                                $location = $locData->regionName . "" . $locData->cityName . "" . $locData->areaCode . "" . $locData->countryName;
                            $location = str_replace(' ', '', $location);
                            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$location&key=AIzaSyD5kISWmBkSJ4WNc7RFiJn5eVpET7uq61U";
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $resultURL = curl_exec($ch);
                            $data = json_decode($resultURL, true);
                            if ($data != null && $data["status"] == "OK") {
                                $latitude = $data["results"][0]["geometry"]["location"]["lat"];
                                $longitude = $data["results"][0]["geometry"]["location"]["lng"];
                                $q->selectRaw("latitude, longitude,
                                                 ( 6371 * acos( cos( radians(?) ) *
                                                   cos( radians( latitude ) )
                                                   * cos( radians( longitude ) - radians(?)
                                                   ) + sin( radians(?) ) *
                                                   sin( radians( latitude ) ) )
                                                 ) AS distance", [$latitude, $longitude, $latitude])
                                    ->having("distance", "<", $radius);
                            }
                        } else {
                            if ($location != null) {
                                $q->where('location', "LIKE", '%' . $location . '%');
                            }
                        }
                    });
                }

                $contacts = $contacts->get();
            }

        foreach($contacts as $key => $c){
            $c['fit'] = \App\Library\LibHelper::skillsFit($c->skills, $skills);
        }
        $sorted = $contacts->sortBy('fit',1,true);
//                $sorted = $contacts->sort(function($a, $b)
//                {
//                    if ($a->fit == $b->fit) {
//                        return 0;
//                    }
//                    return $a->fit < $b->fit;
////                    if ($a["fit"] == $b["fit"]) {
////                        return 0;
////                    }
////                    return ($a["fit"] < $b["fit"]) ? -1 : 1;
//
//                });
        $contacts = $sorted->values()->all();
        return view('src.search',compact('contacts','degrees','positions','languages',
            'searchDegree','content','skills','language','permanent','freelancer','location','radius','level'
        ));
    }
    function cmp($a, $b)
    {
        if ($a["fit"] == $b["fit"]) {
            return 0;
        }
        return ($a["fit"] < $b["fit"]) ? -1 : 1;
    }
    public function __clearSearch(){
        session()->forget(['searchDegree', 'level','location','content','skills','radius','language','permanent','freelancer','searched']);
        return redirect('/search');
    }
    public function __skillsSearch($q, $s){
        $this->attempt +=1;

        $conditionAnd = strpos($s, 'and');
        $conditionOr = strpos($s, 'or');

        if (strpos($s, '(') === false) {

            if ($conditionAnd == false && $conditionOr == false) {
                $s = str_replace('-', ' ', $s);
                $q = $q->where('skill','like','%'.$s.'%');
            } elseif ($conditionAnd == false && $conditionOr != false) {
                $conditionOrs = explode('or', $s);

                if($this->lastCondition == 'or') {
                    $q = $q->orWhereHas('skillRelated',function ($e) use ($conditionOrs){
                        foreach ($conditionOrs as $key=>$or) {
                            if($key==0){
                                $e->whereHas('skillRelated', function($query) use ($or){
                                    $or = str_replace(' ', '', $or);
                                    $or = str_replace('-', ' ', $or);
                                    $query->where('skill','like','%'.$or.'%');
                                });
                            }else{
                                $e->whereHas('skillRelated', function($query) use ($or){
                                    $or = str_replace(' ', '', $or);
                                    $or = str_replace('-', ' ', $or);
                                    $query->orWhere('skill','like','%'.$or.'%');
                                });
                            }
                        }
                    });
                }else{
                    $q = $q->whereHas('skillRelated',function ($e) use ($conditionOrs){
                        foreach ($conditionOrs as $key=>$or) {
                            if($key==0){
                                $e->whereHas('skillRelated', function($query) use ($or){
                                    $or = str_replace(' ', '', $or);
                                    $or = str_replace('-', ' ', $or);
                                    $query->where('skill','like','%'.$or.'%');
                                });
                            }else{
                                //dd($or);
                                $e->orWhereHas('skillRelated', function($query) use ($or){
                                    $or = str_replace(' ', '', $or);
                                    $or = str_replace('-', ' ', $or);
                                    $query->Where('skill','like','%'.$or.'%');
                                });
                            }
                        }
                    });
                }
                return $q;
            }
            elseif ($conditionAnd != false && $conditionOr == false) {
                $conditionAnds = explode('and', $s);
                if($this->lastCondition == 'or') {
                    $q = $q->orWhereHas('skillRelated', function ($e) use ($conditionAnds) {
                        foreach ($conditionAnds as $and) {
                            $e->whereHas('skillRelated', function($query) use ($and){
                                $and = str_replace(' ', '', $and);
                                $and = str_replace('-', ' ', $and);
                                $query->where('skill','like','%'.$and.'%');
                            });
                        }
                    });
                }else{
                    $q = $q->whereHas('skillRelated', function ($e) use ($conditionAnds) {
                        foreach ($conditionAnds as $and) {
                            $e->whereHas('skillRelated', function($query) use ($and){
                                $and = str_replace(' ', '', $and);
                                $and = str_replace('-', ' ', $and);
                                $query->where('skill','like','%'. $and.'%');
                            });
                        }
                    });
                }
            }
        }
        else{
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
                            $e->whereHas('skillRelated', function($query) use ($condition){
                                $condition['string'] = str_replace(' ', '',  $condition['string']);
                                $condition['string'] = str_replace('-', ' ',  $condition['string']);
                                $query->where('skill','like','%'. $condition['string'].'%');
                            });
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__skillsSearch($e, $sx);
                        });
                    }else{
                        $q = $q->whereHas('skillRelated',function ($e) use ($condition, $sx) {
                            $e->whereHas('skillRelated', function($query) use ($condition){
                                $condition['string'] = str_replace(' ', '',  $condition['string']);
                                $condition['string'] = str_replace('-', ' ',  $condition['string']);
                                $query->where('skill','like','%'. $condition['string'].'%');
                            });
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__skillsSearch($e, $sx);
                        });
                    }
                }
                if ($condition['condition'] == 'and') {
                    if($this->lastCondition == 'or') {
                        $q = $q->orWhereHas('skillRelated',function ($e) use ($condition, $sx) {
                            $e->orWhereHas('skillRelated', function($query) use ($condition){
                                $condition['string'] = str_replace(' ', '',  $condition['string']);
                                $condition['string'] = str_replace('-', ' ',  $condition['string']);
                                $query->orWhere('skill','like','%'.$condition['string'].'%');
                            });
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__skillsSearch($e, $sx);
                        });
                    }else{
                        $q = $q->whereHas('skillRelated',function ($e) use ($condition, $sx) {
                            $e->whereHas('skillRelated', function($query) use ($condition){
                                $condition['string'] = str_replace(' ', '',  $condition['string']);
                                $condition['string'] = str_replace('-', ' ',  $condition['string']);
                                $query->where('skill','like','%'.$condition['string'].'%');
                            });
                            $this->lastCondition = $condition['condition'];
                            $e = $this->__skillsSearch($e, $sx);
                        });
                    }
                }
            }
            return $q;


//            if($condition != false) {
//                if ($condition['condition'] == 'and') {
//                    $q = $q->whereHas('skillRelated',function ($e) use ($condition, $sx) {
//                        $e->where('skill','like', '%'.str_replace(' ',  '', $condition['string']).'%');
//                        $e = $this->__skillsSearch($e, $sx);
//                    });
//                }
//                if ($condition['condition'] == 'or') {
//                    $q = $this->q->whereHas('skillRelated',function ($e) use ($condition, $sx) {
//                        $e->orWhere('skill','like','%'.str_replace(' ',  '', $condition['string']).'%');
//                        $e = $this->__skillsSearch($e, $sx);
//                    });
//                }
//            }
            //return $q;
        }
    }
    public function __getBetween($search){
                $newString = null;
        $found = 0; $start = -1; $end = -1;
        for($i=0; $i<strlen($search); $i++){
            if($search[$i] == '(' ){
                if($found == 0){
                    $start = $i;
                }
                $found++;
            }

            if($search[$i] == ')'){
                $found--;
                $end = $i;

                if($start > -1 && $end > 0 && $found == 0){
                    $newString = substr($search, $start+1, (($end-$start)-1));

                }
            }
        }
        if($newString!=null){
            $firstCondition = substr($search, 0, $start)  . substr($search, $end+1, strlen($search));;
            return ['string'=>$newString, 'condition'=>$firstCondition];
        }
        return false;

//        $start = strpos($search,'(');
//        $end = strrpos($search,')');
//        $newString = substr($search,$start+1, ($end-$start)-1);
//        $firstCondition = substr($search, 0, $start)  . substr($search, $end+1, strlen($search));;
//        return ['string'=>$newString, 'condition'=>$firstCondition];
    }
    public function __getValueAndCondition($condition){
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

    public function getUserLatitudeLongitude(){
        $users = Contact::where("status","!=",99)->get();
        foreach($users as $user){
            if($user->location != null){
                $string = $user->location."".$user->plz ."". $user->country;
                $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$string&key=AIzaSyBYU0AHeiV6cYQM3JSi-_rDjJX9LTmi4CY";
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resultURL = curl_exec($ch);
                $data = json_decode($resultURL,true);
                if($data != null && $data['status'] =="OK"){
                    $lat = $data["results"][0]["geometry"]["location"]["lat"];
                    $lng = $data["results"][0]["geometry"]["location"]["lng"];
                    $user->latitude = $lat;
                    $user->longitude = $lng;
                    $user->save();
                }else{
                    print_r("Location failed for User with id ".$user->id);
                }
            }
        }
    }

    public function __activities($id){
        $contact = Contact::where('id',$id)->with('activities')->first();
        return view('src.contacts.activities',compact('contact'));

    }
    public function __changeStatus($contact_id){

        $contact = Contact::where('id',$contact_id)->with('notes')->first();
        $contact->status = request('status');
        $contact->save();
        return redirect("contact/update/$contact_id")->with('modalStatus','modalStatus');
    }

}
