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
    if (! \Illuminate\Support\Facades\Auth::user() || \Illuminate\Support\Facades\Auth::user()->is_admin == FALSE)
        abort(404);

    $shift = \App\Shift::where('user_id', (int)request()->get('user_id'))
        ->where('shift_id',      (int)request()->get('shift'))
        ->where('date_str',      request()->get('date'))
        ->firstOrFail();

    $shift->update([ 'status' =>   (int)request()->get('status') ]);
});

Route::get('shift-add', function () {
    if (\Illuminate\Support\Facades\Auth::user())
        abort(404);

    \App\Shift::create([
        'user_id'  => \Illuminate\Support\Facades\Auth::user()->id,
        'shift_id' => (int)request()->get('shift'),
        'date_str' => request()->get('date'),
        'status'   => 0,
    ]);
});

Route::get('delete-user/{id}', function ($id) {
    if (! \Illuminate\Support\Facades\Auth::user() || \Illuminate\Support\Facades\Auth::user()->is_admin == FALSE)
        abort(404);

    \App\User::findOrFail($id)->delete();

    return back();
});