<?php

use Illuminate\Http\Request;

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

//Api para clientes
Route::get('clientes/{idCliente}','ClienteController@show');
Route::get('clientes/list','ClienteController@listClients');
Route::post('clientes','ClienteController@create');
Route::put('clientes/update','ClienteController@update');
Route::delete('clientes/delete','ClienteController@delete');

//Api para unidades
Route::get('unidades/{idUnidad}','UnidadesController@show');
Route::get('unidades/list','UnidadesController@listUnits');
Route::post('unidades','UnidadesController@create');
Route::put('unidades/update','UnidadesController@update');
Route::delete('unidades/delete','UnidadesController@delete');

//Api para direcciones
Route::get('direcciones/{idDireccion}','DireccionController@show');
Route::get('direcciones/list','DireccionController@listClients');
Route::post('direcciones','DireccionController@create');
Route::put('direcciones/update','DireccionController@update');
Route::delete('direcciones/delete','DireccionController@delete');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('user', 'UserController', ['except' => ['show']]);
Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
Route::get('user-info','UserController@getUserData')->name('user.info');

Route::post('authenticate','Auth\AuthAPIController@authenticate')->name('auth.verification');