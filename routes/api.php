<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace'=>'Api'], function(){
    Route::post('login', 'AuthController@login');
	Route::post('android_login', 'AuthController@android_login');
    Route::post('logout', 'AuthController@logout');
    Route::post('checkToken', 'AuthController@checkToken');
    Route::get('me', 'AuthController@me');
    Route::post('updateProfile', 'AuthController@updateProfile');
    Route::post('updatePassword', 'AuthController@updatePassword');
    Route::post('createUser', 'AuthController@createUser');
    Route::get('getUsers', 'AuthController@getUsers');
    Route::post('updateUser', 'AuthController@updateUser');

    Route::post('admin/index', 'AdminController@index');
    Route::post('addPC', 'AdminController@addPC');
    Route::post('addOther', 'AdminController@addOther');
    Route::post('view/{id}', 'AdminController@view');
    Route::post('updateICT', 'AdminController@update');
    
    Route::post('diagnosis/search/{val}', 'AdminController@search');
    Route::post('diagnosis/create', 'AdminController@createDiags');
    Route::post('diagnosis/index', 'AdminController@indexDiags');
    Route::post('diagnosis/{cn}', 'AdminController@getDiag');

    Route::post('clearance/create', 'AdminController@createClearance');
    Route::get('clearance/index', 'AdminController@indexClearance');
    Route::post('clearance/{cn}', 'AdminController@getClearance');

    Route::get('dashboard', 'AdminController@dashboard');
	
    Route::get('android/{device_id}', 'AdminController@indexAndroid');
	Route::post('android/create_prev_maintenance', 'AdminController@addMaintenance');

    Route::post('preventive_maintenance/index', 'AdminController@indexPreventiveMaintenance');
});