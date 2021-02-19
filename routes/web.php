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

Route::group(['middleware' => ['guest']], function() {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('principal');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/main', function () {
        return view('contenido.contenido');
    })->name('main');

    Route::get('/conteo', 'PrincipalController@index');

    Route::group(['middleware' => ['Administrador']], function(){
        
        Route::get('/tecnicos', 'TecnicoController@index');
        Route::get('/tecnicos/selectTecnicos', 'TecnicoController@selectTecnicos');
        Route::post('/tecnicos/registrar', 'TecnicoController@store');
        Route::put('/tecnicos/actualizar', 'TecnicoController@update');
        Route::put('/tecnicos/desactivar', 'TecnicoController@desactivar');
        Route::put('/tecnicos/activar', 'TecnicoController@activar');
        
        Route::get('/roles', 'RolController@index');
        Route::get('/roles/selectRol', 'RolController@selectRol');
        
        Route::get('/usuarios', 'UserController@index');
        Route::get('/usuarios/unico/{usuario}', 'UserController@unico');
        Route::get('/usuarios/unico/{usuario}/{user_id}', 'UserController@unico2');
        Route::get('/usuarios/unicoEmail/{email}', 'UserController@unico3');
        Route::get('/usuarios/unicoEmail/{email}/{user_id}', 'UserController@unico4');
        Route::get('/usuarios/getUser', 'UserController@getUser');
        Route::get('/usuarios/selectUser', 'UserController@selectUser');
        Route::post('/usuarios/registrar', 'UserController@store');
        Route::put('/usuarios/actualizar', 'UserController@update');
        Route::put('/usuarios/desactivar', 'UserController@desactivar');
        Route::put('/usuarios/activar', 'UserController@activar');
        
        Route::get('/clientes', 'ClienteController@index');
        Route::get('/clientes/sidco', 'ClienteController@actualizarSidco');
        Route::get('/clientes/unico/{codigoavl}/{cliente_id}', 'ClienteController@unico');
        Route::get('/clientes/selectClientes', 'ClienteController@selectClientes');
        Route::put('/clientes/actualizarCodigoAVL', 'ClienteController@actualizarCodigoAVL');
        Route::put('/clientes/actualizar', 'ClienteController@actualizarCliente');

        Route::get('/simcards', 'SimCardController@index');
        Route::get('/simcards/selectSim', 'SimCardController@selectSim');

        Route::get('/gps', 'GpsController@index');
        Route::get('/gps/selectGps', 'GpsController@selectGps');

        Route::get('/vehiculos', 'VehiculoController@index');
        Route::get('/vehiculos/selectVehiculo', 'VehiculoController@selectVehiculo');

        Route::get('/actividadestecnicas', 'ActividadTecnicaController@index');
        Route::post('/actividadestecnicas/registrar', 'ActividadTecnicaController@store');
        Route::put('/actividadestecnicas/confirmar', 'ActividadTecnicaController@confirmar');
        Route::put('/actividadestecnicas/desconfirmar', 'ActividadTecnicaController@desconfirmar');

        Route::get('/cambiosimcards/mostrar/{id_actividadtecnica}', 'CambioSimCardControler@mostrar');
        Route::get('/obtenerImagenCambioSim/{filename}', 'CambioSimCardControler@getImageB64');
        Route::post('/cambiosimcards/registrar', 'CambioSimCardControler@store');
        Route::put('/cambiosimcards/actualizar', 'CambioSimCardControler@update');

        Route::get('/cambiogps/mostrar/{id_actividadtecnica}', 'CambioGpsController@mostrar');
        Route::get('/obtenerImagenCambioGps/{filename}', 'CambioGpsController@getImageB64');
        Route::post('/cambiogps/registrar', 'CambioGpsController@store');
        Route::put('/cambiogps/actualizar', 'CambioGpsController@update');

        Route::get('/desinstalaciones/mostrar/{id_actividadtecnica}',    'DesinstalacionController@mostrar');
        Route::get('/obtenerImagenDesinstalacion/{filename}', 'DesinstalacionController@getImageB64');
        Route::post('/desinstalaciones/registrar', 'DesinstalacionController@store');
        Route::put('/desinstalaciones/actualizar', 'DesinstalacionController@update');

        Route::get('/homologaciones/mostrar/{id_actividadtecnica}', 'HomologacionController@mostrar');
        Route::get('/obtenerImagenHomologacion/{filename}', 'HomologacionController@getImageB64');
        Route::post('/homologaciones/registrar', 'HomologacionController@store');
        Route::put('/homologaciones/actualizar', 'HomologacionController@update');
        
        Route::get('/instalaciones/mostrar/{id_actividadtecnica}',    'InstalacionNuevaController@mostrar');
        Route::get('/obtenerImagenInstalacion/{filename}', 'InstalacionNuevaController@getImageB64');
        Route::post('/instalaciones/registrar', 'InstalacionNuevaController@store');
        Route::put('/instalaciones/actualizar', 'InstalacionNuevaController@update');

        Route::get('/reinstalaciones/mostrar/{id_actividadtecnica}', 'ReinstalacionController@mostrar');
        Route::get('/obtenerImagenReinstalacion/{filename}', 'ReinstalacionController@getImageB64');
        Route::post('/reinstalaciones/registrar', 'ReinstalacionController@store');
        Route::put('/reinstalaciones/actualizar', 'ReinstalacionController@update');

        Route::get('/revisiones/mostrar/{id_actividadtecnica}', 'RevisionController@mostrar');
        Route::get('/obtenerImagenRevisiones/{filename}', 'RevisionController@getImageB64');
        Route::post('/revisiones/registrar', 'RevisionController@store');
        Route::put('/revisiones/actualizar', 'RevisionController@update');

        Route::get('/trasladosgps/mostrar/{id_actividadtecnica}', 'TrasladoGpsController@mostrar');
        Route::get('/obtenerImagenTrasladoGps/{filename}', 'TrasladoGpsController@getImageB64');
        Route::post('/trasladosgps/registrar', 'TrasladoGpsController@store');
        Route::put('/trasladosgps/actualizar', 'TrasladoGpsController@update');

        Route::post('/reportes/actividadtecnica', 'ReporteriaController@actividadtecnica');

    });
    
    //Route::get('/home', 'HomeController@index')->name('home');
    
});

