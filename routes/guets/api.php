<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest'],
    'prefix' => 'notifications'], function() {

    Route::post('notificacion',[\App\Http\Controllers\Notificaicones\guest\NotificationController::class,'guestStore']);
    Route::put('notificacion/{id}',[\App\Http\Controllers\Notificaicones\guest\NotificationController::class,'guestUpdate']);

    //recursos globals

    Route::get('empresas',[\App\Http\Controllers\Guest\RecursosController::class,'getEmpresas']);

    Route::get('filter_for_procedure',[\App\Http\Controllers\Guest\TramiteAuraController::class,'findTramite']);
});

Route::group(['middleware' => ['guest'],
    'prefix' => 'aura'], function() {
    Route::get('filter_for_procedure/{id}',[\App\Http\Controllers\Guest\TramiteAuraController::class,'findTramite']);
});


Route::group(['middleware' => ['guest'],
    'prefix' => 'sifo'], function() {
    Route::post('migrate_sql_oracle',[\App\Http\Controllers\Guest\QueryMigrateSqlOracleController::class,'migrateInformation']);

    Route::get('nosotros',[\App\Http\Controllers\Informations\Auth\InformationAllController::class,'index']);
    Route::get('nosotros/{id}',[\App\Http\Controllers\Informations\Auth\InformationAllController::class,'show']);
    Route::post('nosotros',[\App\Http\Controllers\Informations\Auth\InformationAllController::class,'store']);
    Route::put('nosotros/{id}',[\App\Http\Controllers\Informations\Auth\InformationAllController::class,'update']);
    Route::delete('nosotros/{id}',[\App\Http\Controllers\Informations\Auth\InformationAllController::class,'delete']);


    Route::post('emials/masivos',[\App\Http\Controllers\Mail\Masivos\Guest\SendEmailMorosidadController::class,'sendEmailsMasivos']);


});

Route::group(['middleware' => ['guest'],
    'prefix' => 'digital'], function() {

    Route::get('admin-tramites/{doc}',[\App\Http\Controllers\Guest\TramiteAuraController::class,'getAdministradoTramites']);
    Route::get('tramites/{doc}',[\App\Http\Controllers\Guest\TramiteAuraController::class,'getTramites']);
    Route::get('areas',[\App\Http\Controllers\Guest\RecursosController::class,'getAreas']);

    Route::get('departamentos',[\App\Http\Controllers\Guest\RecursosController::class,'getDepartamentos']);
    Route::get('provincias/{id}',[\App\Http\Controllers\Guest\RecursosController::class,'getProvincias']);
    Route::get('distritos/{id}',[\App\Http\Controllers\Guest\RecursosController::class,'getDistritos']);


});


