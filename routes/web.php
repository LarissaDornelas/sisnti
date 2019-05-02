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

/*
 * Auth routes
 */
Route::get('/', function () {
    return redirect('/login');
})->name('/');

Route::get('/login', 'Auth\AuthController@showLogin')->name('showLogin');
Route::post('/login', 'Auth\AuthController@validateLogin')->name('login');

Route::get('/logout', function () {
    Session::flush();
    Auth::logout();
    return redirect(\URL::previous());
})->name('logout');

/**
 * Task routes
 */
Route::get('/solicitacao', 'taskController@allTask')->name('allTask');
Route::get('/solicitacao/novo', 'TaskController@getOpenTask')->name('showOpenTask');
Route::post('/solicitacao/novo', 'TaskController@postOpenTask')->name('openTask');




Route::get('/dashboard','DashController@showDash')->name('dashboard');



