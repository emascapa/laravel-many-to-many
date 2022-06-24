<?php

use Illuminate\Support\Facades\Route;

//utilizzerò Auth
use Illuminate\Support\Facades\Auth;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

//Route::get('/home', 'Admin\HomeController@index')->name('home');


//raggruppo le rotte di admin
Route::middleware('auth')->namespace('Admin')->name('admin.')->prefix('admin')
    ->group(function () {

        Route::get('/', 'HomeController@index')->name('index');

        Route::resource('posts', 'PostController');


        Route::resource('categories', 'CategoryController');

    });



//ULTIMOO 

Route::get("{any?}", function() {
    return view('guest.home');
})->where("any", ".");