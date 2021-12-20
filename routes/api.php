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
Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('promo','Api\PromoController@index');
    Route::get('promo/{id}','Api\PromoController@show');
    Route::post('promo','Api\PromoController@store');
    Route::put('promo/{id}','Api\PromoController@update');
    Route::delete('promo/{id}','Api\PromoController@destroy');
    
    Route::get('order','Api\OrderController@index');
    Route::get('order/{id}','Api\OrderController@show');
    Route::post('order','Api\OrderController@store');
    Route::put('order/{id}','Api\OrderController@update');
    Route::delete('order/{id}','Api\OrderController@destroy');

    Route::get('pegawai','Api\PegawaiController@index');
    Route::get('pegawai/{id}','Api\PegawaiController@show');
    Route::post('pegawai','Api\PegawaiController@store');
    Route::put('pegawai/{id}','Api\PegawaiController@update');
    Route::delete('pegawai/{id}','Api\PegawaiController@destroy');
    
    Route::get('user','Api\AuthController@index');
    Route::get('user/{id}','Api\AuthController@show');
    Route::put('user/{id}','Api\AuthController@update');
    Route::delete('user/{id}','Api\AuthController@destroy');
    
    Route::put('update_password/{id}','Api\AuthController@update_password');
    Route::put('date/{id}','Api\AuthController@update_date');

    Route::get('logout','Api\AuthController@logout');
});
