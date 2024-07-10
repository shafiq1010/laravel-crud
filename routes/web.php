<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\UserController;
//Route::get('/', function () {
//    return view('user.index');
//});

Route::get('/',[UserController::class,'index']);
Route::post('user/signin', 'App\Http\Controllers\UserController@signin');
Route::get('user/logout', 'App\Http\Controllers\UserController@logout');

Route::resource('user', UserController::class);
 

//Route::get('/create','UserController@create');
//Route::resource('users', UserController::class);


//Route::get('/', 'App\Http\Controllers\UserController@index');
//Route::get('/create', 'App\Http\Controllers\UserController@create');
//Route::post('/store', 'App\Http\Controllers\UserController@store');


//Route::post('/update/{id}', 'App\Http\Controllers\UserController@update');

//Route::post('/delete/{id}', 'App\Http\Controllers\UserController@delete');

//Route::get('/insert', 'App\Http\Controllers\CrudController@create'); 
//Route::post('/insert', 'CrudController@store');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
