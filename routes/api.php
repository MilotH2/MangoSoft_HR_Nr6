<?php

Route::post('skills','SkillController@index');
Route::post('skill/add','SkillController@store');
Route::post('skill/delete','SkillController@destroy');

Route::post('skills/all','SkillController@__allSkill');

Route::post('positions','PositionController@index');
Route::post('position/add','PositionController@store');
Route::post('position/delete','PositionController@destroy');

Route::post('degrees','DegreeController@index');
Route::post('degree/add','DegreeController@store');
Route::post('degree/delete','DegreeController@destroy');

Route::post('languages','LanguageController@index');
Route::post('language/add','LanguageController@store');
Route::post('language/delete','LanguageController@destroy');

Route::post('nationalities','NationalityController@index');
Route::post('nationality/add','NationalityController@store');
Route::post('nationality/delete','NationalityController@destroy');



Route::post('getTasksForKanban','TaskController@getTasksForKanban');
Route::post('updateStatus','TaskController@updateTaskStatus');
Route::post('deleteTask','TaskController@deleteTask');
Route::post('getAdministrators','TaskController@getAdministrators');
Route::post('assignAdministrator','TaskController@assignAdministrator');
//Route::post('addColumn','TaskController@addColumn');

Route::post('getStatusesForKanban','StatusController@getStatusesForKanban');
Route::post('updateStatusStatus','StatusController@updateStatuses');
Route::post('archiveStatus','StatusController@archive');

