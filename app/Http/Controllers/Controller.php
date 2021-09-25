<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function makeDatabaseChanges(){
        $tasks = Task::all();
   //     dd($tasks);
//        $migrations = DB::table('migrations')->get();
//        dd($migrations);
        //Artisan::call('migrate');
    }
    public function index()
    {
        if(auth()->check()){
            return redirect('/contact/list');
        }
        return view('src.home.home');
    }
}
