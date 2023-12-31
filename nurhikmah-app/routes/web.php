<?php

use Illuminate\Support\Facades\Auth;
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



Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get("/", function (){
   return view("home");
});

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/exam', 'App\Http\Controllers\ExamController@index');
Route::get('/question', 'App\Http\Controllers\QuestionController@index');
Route::delete('/exam/{id}', 'App\Http\Controllers\ExamController@destroy');
Route::resource('siswa', 'App\Http\Controllers\SiswaController');
Route::resource('question', 'App\Http\Controllers\QuestionController');
Route::resource('jawaban', 'App\Http\Controllers\JawabanController');

/** for siswa page **/
Route::get('/login', 'App\Http\Controllers\SiswaLoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\SiswaLoginController@login')->name('login.post');
Route::post('/logout', 'App\Http\Controllers\SiswaLoginController@logout')->name('logout');



Route::get('/thank-you', 'App\Http\Controllers\JawabanController@thankYou')->name('thank-you');

/** for middleware **/
Route::group(["middleware" => ["auth", "level.check:admin",]], function(){
    Route::resource('/exam', 'App\Http\Controllers\ExamController');
});

Route::group(["middleware" => ["auth",'examaccess', "level.check:siswa"]], function(){
    Route::resource('/exam', 'App\Http\Controllers\ExamController');
});
