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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// v1/contacts
Route::get('v1/contacts', 'ContactsController@index');
Route::get('v1/contacts/{id}', 'ContactsController@show');
Route::post('v1/contacts', 'ContactsController@store');
Route::patch('v1/contacts/{id}', 'ContactsController@update');
Route::delete('v1/contacts/{id}', 'ContactsController@destroy');
// v1/phones
Route::get('v1/phones', 'PhonesController@index');
Route::get('v1/phones/{id}', 'PhonesController@show');
Route::post('v1/phones', 'PhonesController@store');
Route::patch('v1/phones/{id}', 'PhonesController@update');
Route::delete('v1/phones/{id}', 'PhonesController@delete');
