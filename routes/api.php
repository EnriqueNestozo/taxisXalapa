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

//Api para registros diarios
Route::post('registrosDiarios','RegistrosDiariosController@create')->name('api.registros.diarios.create')->middleware('auth:api');
Route::get('registros-diarios-list','RegistrosDiariosController@listRecords')->name('api.registros.diarios.list')->middleware('auth:api');
Route::get('registros-diarios/{idRegistro}','RegistrosDiariosController@show')->name('api.get.registro')->middleware('auth:api');
Route::post('registros-diarios-delete','RegistrosDiariosController@delete')->name('api.delete.registro')->middleware('auth:api');
//Api para clientes
Route::get('clientes/{idCliente}','ClienteController@show')->name('api.get.cliente')->middleware('auth:api');
Route::get('clientes-list','ClienteController@listClients')->name('api.clientes.list')->middleware('auth:api');
Route::get('get-clientes','ClienteController@getClientes')->name('api.get.clientes')->middleware('auth:api');
Route::post('clientes','ClienteController@create');
Route::put('clientes-update','ClienteController@update')->name('api.update.cliente')->middleware('auth:api');
Route::delete('clientes/delete','ClienteController@delete');

//Api para unidades
// Route::get('unidades/{idUnidad}','UnidadesController@show');
Route::get('unidades-list','UnidadController@listUnits')->name('api.unidades.list')->middleware('auth:api');
Route::get('get-unidades','UnidadController@getUnidades')->name('api.get.unidades')->middleware('auth:api');
// Route::post('unidades','UnidadesController@create');
// Route::put('unidades/update','UnidadesController@update');
// Route::delete('unidades/delete','UnidadesController@delete');

//Api para direcciones
// Route::get('direcciones/{idDireccion}','DireccionController@show');
// Route::get('direcciones-list','DireccionController@listClients');
Route::get('get-direcciones/{idCliente}','DireccionController@getDirecciones')->name('api.get.direcciones')->middleware('auth:api');
// Route::post('direcciones','DireccionController@create');
// Route::put('direcciones/update','DireccionController@update');
// Route::delete('direcciones/delete','DireccionController@delete');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::resource('user', 'UserController', ['except' => ['show']]);
// Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
// Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
// Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
// Route::get('user-info','UserController@getUserData')->name('user.info');

// Route::post('authenticate','Auth\AuthAPIController@authenticate')->name('api.auth.verification');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthAPIController@login')->name('api.login');
    Route::post('signup', 'Auth\AuthAPIController@signup')->name('api.signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Auth\AuthAPIController@logout');
        Route::get('user', 'Auth\AuthAPIController@user');
    });
});