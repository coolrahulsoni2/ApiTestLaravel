<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// get list of Category
Route::get('category','categoryController@category');
// get list of Category
Route::get('subcategory/{id}','categoryController@subcategory');
// get list of Apis
Route::get('Apis','ApiController@index');
// get list of Leads
Route::get('leads/{id}','categoryController@leads');
// get specific Api
Route::post('login','categoryController@login');
// delete a Api
Route::delete('Api/{id}','ApiController@destroy');
// update existing Api
Route::put('Api','ApiController@store');
// create new Api
Route::post('Api','ApiController@store');

