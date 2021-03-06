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

Route::get('/', function () {
    return view('welcome');
});
/*
Route::get('/punto/{id}','PuntoController@index');

Route::get('/ruta','PuntoController@ruta');



*/
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/task', 'TaskController');
Route::resource('/colectivo', 'ColectivoController');
Route::resource('/recorrido', 'RecorridoController');