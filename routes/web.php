<?php

use Illuminate\Support\Facades\Route;

Route::get('/', "Controller@index");


Route::get('/start','ContactController@show');

Route::group(['prefix'=>'contact'], function(){
    Route::post('/save','ContactController@__storeContact');
    Route::get('/update/{id}','ContactController@show');

});
Route::match(['get','post'],'/search2','HomeController@filterSearch');
Route::middleware('auth')->group(function() {
//    Route::get('/', function () {
//        return redirect('/contact/list');
//        //return view('src.dashboard');
//    });
    Route::get("/dashboard","HomeController@dashboard");
    Route::get("/users","EmployeeController@index");
    Route::get("/makeDatabaseChanges","Controller@makeDatabaseChanges");

    Route::get("/tasks","TaskController@tasks");
    Route::get("/statuses","StatusController@statuses");
    Route::post('/activity/note/store',"ActivityController@__storeNote");

//temporary linkgs
    Route::get("/delete/task/{id}","TaskController@delete");
    Route::get("/delete/status/{id}","TaskController@deleteStatus");
    Route::get("/getUserLatLong","ContactController@getUserLatitudeLongitude");

    Route::group(['prefix' => 'task'], function () {
        Route::post("/create","TaskController@__createTask");
    });
    Route::group(['prefix' => 'user'], function () {
        Route::post("/add/{id?}","EmployeeController@user");
        Route::match(['get','post'],"/edit/{id}","EmployeeController@edit");
        Route::get("/activate/{id}","EmployeeController@activate");
        Route::get("/deactivate/{id}","EmployeeController@deactivate");
    });

    Route::group(['prefix'=>'contact'], function(){
        Route::get('/list','ContactController@index');
        Route::get('/add','ContactController@show');
//        Route::get('/update/{id}','ContactController@show');
//        Route::post('/save','ContactController@__storeContact');
        Route::get('/activities/{id}','ContactController@__activities');
        Route::get('/activities/{id}','ContactController@__activities');
        Route::post('/{id}/saveNote','NoteController@__saveNote');
        Route::post('/{id}/changeStatus','ContactController@__changeStatus');

    });
    Route::match(['get','post'],'/search','ContactController@__search');
    Route::get('/search/clear','ContactController@__clearSearch');
    Route::match(['post'],'/generalSearch','ContactController@__generalSearch');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
