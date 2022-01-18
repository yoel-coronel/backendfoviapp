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

