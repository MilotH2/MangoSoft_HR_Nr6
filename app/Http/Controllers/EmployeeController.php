<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $users = User::where("role","!=",1)->get();
        return view("src.users",compact("users"));
    }

    public function user($id = null){
        request()->validate([
            'firstname'                      => ['required', 'string', 'max:191'],
            'lastname'                      => ['required', 'string', 'max:191'],
        ]);

        if(request()->has("password") && \request('password') != null){
            request()->validate([
                'password'                  => ['required', 'string', 'min:6','confirmed'],
                'password_confirmation'     => ['string', 'min:6'],
            ]);
        }
        if($id != null){
            $user = User::find($id);
            if($user == null){
                return back()->with("errors","Error user not found!");
            }
        }else{
            request()->validate([
                'email'                     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
            $user = new User();
        }


        $user->firstname = request("firstname");
        $user->lastname = request("lastname");
        $user->email = request("email");

        if(request()->has("password") && \request('password') != null) {
            $user->password = bcrypt(request('password'));
        }

        $user->address = request("address");
        $user->position = request("position");
        $user->profile_picture = "default.png";
        $user->role = 2;
        $user->save();
        return redirect("/users")->with("success","User added successfully");
    }

    public function edit($id){
        $user = User::find($id);
        $users = User::where("role","!=",1)->get();
        return view("src.users",compact("user","users"));

    }

    public function activate($id){
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();
        return redirect('users')->with("success","User Activated Successfully");
    }

    public function deactivate($id){
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();
        return redirect('users')->with("success","User Deactivated Successfully");
    }

//    public function activate($id){
//        $slider = Slider::find($id);
//        if($slider == null){
//            return back()->with("errors","Error slider not found!");
//        }
//        $slider->status = 1;
//        $slider->save();
//        return back()->with("success","Success slider Activated!");
//    }
//
//    public function deactivate($id){
//        $slider = Slider::find($id);
//        if($slider == null){
//            return back()->with("errors","Error slider not found!");
//        }
//        $slider->status = 0;
//        $slider->save();
//        return back()->with("success","Success slider Deactivated!");
//    }
}
