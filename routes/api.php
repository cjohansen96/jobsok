<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Job applications */

// List Jobapplications
Route::get('jobapplications', 'App\Http\Controllers\JobapplicationController@index');

// List jobapplication by order value
Route::get('jobapplications/{orderby}', 'App\Http\Controllers\JobapplicationController@orderbyJobapplications');

// List Single jobapplication
Route::get('jobapplication/{id}', 'App\Http\Controllers\JobapplicationController@show');

// Create new jobapplication
Route::post('jobapplication', 'App\Http\Controllers\JobapplicationController@store');

// Update jobapplication
Route::put('jobapplication', 'App\Http\Controllers\JobapplicationController@store');

// Delete jobapplication
Route::delete('jobapplication/{id}', 'App\Http\Controllers\JobapplicationController@destroy');

