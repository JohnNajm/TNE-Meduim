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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Public Routes
Route::post('/login', 'App\Http\Controllers\UserController@login');
Route::get('/getlistings', 'App\Http\Controllers\ListingsController@index');
Route::get('/getlisting/{id}', 'App\Http\Controllers\ListingsController@show');



// END

Route::middleware(['auth:sanctum', 'type.User'])->group(function () {
    //Min authorization: User
    Route::post('/storelisting', 'App\Http\Controllers\ListingsController@store');
    Route::get('/getuserlistings', 'App\Http\Controllers\ListingsController@registeredindex');
    Route::get('/getuserlisting/{id}', 'App\Http\Controllers\ListingsController@registeredshow');
    Route::get('/getuserlisting/{id}', 'App\Http\Controllers\ListingsController@registeredshow');
    Route::post('/createuserlisting', 'App\Http\Controllers\ListingsController@store');
    
    Route::delete('/deletelisting/{id}', 'App\Http\Controllers\ListingsController@destroy');
    Route::put('/editlisting/{id}','App\Http\Controllers\ListingsController@update');
    
    Route::post('/createcomment', 'App\Http\Controllers\CommentsController@store');
    
    Route::post('/sendmessage', 'App\Http\Controllers\MessagesController@store');
    
    
    Route::get('/getcategories', 'App\Http\Controllers\CategoriesController@index');
    Route::get('/getcategory/{id}', 'App\Http\Controllers\CategoriesController@show');
    
    
    
    
});


Route::middleware(['auth:sanctum', 'type.Moderator'])->group(function () {
    //Min authorization: Moderator
    Route::patch('/hidelisting/{id}','App\Http\Controllers\ListingsController@hide');
    
    Route::post('/createcategory', 'App\Http\Controllers\CategoriesController@store');
    Route::delete('/deletecategory/{id}', 'App\Http\Controllers\CategoriesController@destroy');
    
    
});

Route::middleware(['auth:sanctum', 'type.Admin'])->group(function () {
    //Min authorization: Admin
    Route::delete('/sudpdeletelisting/{id}', 'App\Http\Controllers\ListingsController@sudodestroy');
    Route::put('/sudoeditlisting/{id}','App\Http\Controllers\ListingsController@sudoupdate');
    
});




