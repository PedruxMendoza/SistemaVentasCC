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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
//Generar Facturas
Route::get('/factura', 'Invoice@index');
Route::post('/ajaxClientes', 'Invoice@ajaxDailyCustomer');
Route::get('/ajaxgetClientes', 'Invoice@ajaxGetCustomer');
Route::post('/ajaxCreditos', 'Invoice@ajaxCreditCustomer');
Route::post('/ajaxClienteNuevo', 'Invoice@ajaxNewCustomer');
Route::post('/ajaxPrecio', 'Invoice@ajaxPricesProductos');
Route::post('/ajaxStock', 'Invoice@ajaxStockProductos');
Route::post('/ajaxAgregar', 'Invoice@ajaxAddProducts');
Route::get('/carrito', 'Invoice@carrito');
Route::post('/ajaxRemover', 'Invoice@remover');
Route::post('/facturar1', 'Invoice@facturarContado');
Route::post('/facturar2', 'Invoice@facturarTarjeta');
//Listado de Factura con Detalles
Route::get('/listado', 'Invoice@mostrarListado');
Route::get('/detalles/{id}', 'Invoice@mostrardetalles');
Route::get('/pdf', 'Invoice@pdf');
//Errores
Route::get('/404', 'HomeController@error404');
//Envio de correo
Route::get('/correolvidado', 'Correos@index');
Route::post('/enviado', 'Correos@enviar');
//Cambio de Contraseña
Route::post('/cambiarcontra', 'Correos@CambiarContra');
//Reportes
Route::get('/contado', 'Reportes@contado');
Route::get('/credito', 'Reportes@credito');
Route::get('/cajero', 'Reportes@cajero');
Route::get('/graficas', 'Reportes@graficas');
Route::post('/credito/resultado', 'Reportes@mostrarcredito');
Route::post('/contado/resultado', 'Reportes@mostrarcontado');
Route::post('/cajero/resultado', 'Reportes@mostrarcajero');
Route::post('/pdfcontado', 'Reportes@pdfcontado');
Route::post('/pdfcredito', 'Reportes@pdfcredito');
Route::post('/pdfcajero', 'Reportes@pdfcajero');

Route::get('/home', 'HomeController@index')->name('home');
