<?php

use App\Http\Controllers\HomeController;
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

//Route::get('/login', \App\Http\Controllers\Auth\LoginController::)

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index');
});

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
//})->where('any', '.*')->middleware('auth');

