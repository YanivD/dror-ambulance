<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('shift-change', function () {
    \App\Shift::where('user_id', (int)request()->get('user_id'))
        ->where('shift_id',      (int)request()->get('shift'))
        ->where('date_str',      request()->get('date'))
        ->update([ 'status' =>   (int)request()->get('status') ]);
});

Route::get('shift-add', function () {
    \App\Shift::create([
        'user_id'  => \Illuminate\Support\Facades\Auth::user()->id,
        'shift_id' => (int)request()->get('shift'),
        'date_str' => request()->get('date'),
        'status'   => 0,
    ]);
});