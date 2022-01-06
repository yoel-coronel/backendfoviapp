<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest'],
    'prefix' => 'notifications'], function() {

    Route::post('notificacion',[\App\Http\Controllers\Notificaicones\guest\NotificationController::class,'guestStore']);
    Route::put('notificacion/{id}',[\App\Http\Controllers\Notificaicones\guest\NotificationController::class,'guestUpdate']);

    //recursos globals

    Route::get('empresas',[\App\Http\Controllers\Guest\RecursosController::class,'getEmpresas']);
});
