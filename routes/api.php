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
//Api para reportes
Route::get('reporte-registros','ReportesController@listRecords')->name('api.registros.list')->middleware('auth:api');
Route::get('reporte-corte-taxi','ReportesController@reportePorCorteTaxi')->name('api.reporte.taxi')->middleware('auth:api');
Route::get('reporte-cliente','ReportesController@reportePorCliente')->name('api.reporte.cliente')->middleware('auth:api');


//Api para registros diarios
Route::post('registrosDiarios','RegistrosDiariosController@create')->name('api.registros.diarios.create')->middleware('auth:api');
Route::post('registrosDestinos','RegistrosDiariosController@createDestino')->name('api.registros.destino.create')->middleware('auth:api');
Route::post('registrosDestinosEliminar','RegistrosDiariosController@deleteDestino')->name('api.destino.delete')->middleware('auth:api');
Route::get('registros-diarios-list/{tipoRegistro}','RegistrosDiariosController@listRecords')->name('api.registros.diarios.list')->middleware('auth:api');
Route::get('registros-diarios/{idRegistro}','RegistrosDiariosController@show')->name('api.get.registro')->middleware('auth:api');
Route::post('registros-diarios-delete','RegistrosDiariosController@delete')->name('api.delete.registro')->middleware('auth:api');
//Api para clientes
Route::get('clientes/{idCliente}','ClienteController@show')->name('api.get.cliente')->middleware('auth:api');
Route::get('clientes-list','ClienteController@listClients')->name('api.clientes.list')->middleware('auth:api');
Route::get('get-clientes','ClienteController@getClientes')->name('api.get.clientes')->middleware('auth:api');
Route::post('clientes','ClienteController@create')->name('api.create.cliente')->middleware('auth:api');
Route::put('clientes-update','ClienteController@update')->name('api.update.cliente')->middleware('auth:api');
Route::post('clientes/delete','ClienteController@delete')->name('api.delete.cliente')->middleware('auth:api');

/*
    Api para unidades
*/

//Mostrar detalles de una unidad 
Route::get('unidades/{idUnidad}','UnidadController@show')->name('api.get.unidad')->middleware('auth:api');
//Datatable ded lista de unidades
Route::get('unidades-list','UnidadController@listUnits')->name('api.unidades.list')->middleware('auth:api');
//Obtener todas las unidades (no se usa)
Route::get('get-unidades','UnidadController@getUnidades')->name('api.get.unidades')->middleware('auth:api');
//Crear/Editar una unidad
Route::post('unidades','UnidadController@create')->name('api.create.unidad')->middleware('auth:api');
// Route::put('unidades/update','UnidadesController@update');
//Eliminar una unidad
Route::post('unidades/delete','UnidadController@delete')->name('api.delete.unidad')->middleware('auth:api');

/*
   Api para conductores
*/
//Crea un conductor
Route::post('conductores','ConductorController@create')->name('api.create.conductor')->middleware('auth:api');
//Modificar conductor
Route::get('conductores/{idConductor}','ConductorController@show')->name('api.edit.conductor')->middleware('auth:api');
//Listado para select de conductores
Route::get('conductores','ConductorController@listadoConductores')->name('api.conductores.get')->middleware('auth:api');
//Listado de conductores en datatable
Route::get('conductores-list','ConductorController@listConductores')->name('api.conductores.get.list')->middleware('auth:api');
//Eliminar un conductor y de las unidades donde se encuentra
Route::post('conductores/delete','ConductorController@delete')->name('api.delete.conductor')->middleware('auth:api');
/*
   Api para unidades-conductores
*/
//Obtener los conductores de una unidad
Route::get('unidad-conductor/{idUnidad}','UnidadController@conductoresPorUnidad')->name('api.conductores.conductorunidad.get')->middleware('auth:api');
//Crear relación unidad-conductor
Route::post('unidad-conductor','UnidadController@CrearRelacionconductoresUnidad')->name('api.conductores.conductorunidad.post')->middleware('auth:api');
//Eliminar relacion unidad-conductor
Route::post('unidad-conductor-delete','UnidadController@EliminarRelacionconductoresUnidad')->name('api.conductores.conductorunidad.delete')->middleware('auth:api');


/*
    Api para direcciones
*/
Route::get('direcciones/{idDireccion}','DireccionController@show')->name('api.get.direccion')->middleware('auth:api');
// Route::get('direcciones-list','DireccionController@listClients');
Route::get('get-direcciones/{idCliente}','DireccionController@getDirecciones')->name('api.get.direcciones')->middleware('auth:api');
Route::get('get-direcciones-destino/{idCliente}','DireccionController@getDireccionesDestino')->name('api.get.destino')->middleware('auth:api');
// Route::post('direcciones','DireccionController@create');
// Route::put('direcciones/update','DireccionController@update');
// Route::delete('direcciones/delete','DireccionController@delete');

//Api para cat municipios, localidades y colonias
Route::get('municipios','CatalogosController@getMunicipios')->name('api.get.municipios');
Route::get('localidades/{idMunicipio}','CatalogosController@getLocalidades')->name('api.get.localidades');
Route::get('colonias/{idLocalidad}','CatalogosController@getColonias')->name('api.get.colonias');

//Api para servicios
Route::get('servicios-list','ServicioController@listRecords')->name('api.servicios.list')->middleware('auth:api');
Route::post('servicios','ServicioController@create')->name('api.servicios.create')->middleware('auth:api');
Route::get('servicio/{idRegistro}','ServicioController@show')->name('api.servicio.get')->middleware('auth:api');
Route::get('servicio-actual/{idRegistro}','ServicioController@showWithCurrentScheedule')->name('api.servicio.actual')->middleware('auth:api');
Route::post('servicio-delete','ServicioController@delete')->name('api.servicio.delete')->middleware('auth:api');
Route::post('servicio-cancel','ServicioController@cancelarServicio')->name('api.servicio.cancel')->middleware('auth:api');
Route::get('servicios-pendientes','ServicioController@numServiciosPendientes')->name('api.servicios.pendientes')->middleware('auth:api');
Route::get('lista-servicios-pendientes','ServicioController@listaServiciosPendientes')->name('api.servicios.pendientes.list')->middleware('auth:api');
Route::get('servicios-datos/{idServicio}','ServicioController@obtenerDatosServicioPendiente')->name('api.servicios.datos')->middleware('auth:api');


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

Route::post('user', 'UserController@store')->name('api.user.create')->middleware('auth:api');