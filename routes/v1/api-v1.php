<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\v1\AuthController;
use App\Http\Controllers\Auth\v1\RegisterUserController;
use App\Http\Controllers\Auth\v1\ForgotPasswordController;
use App\Http\Controllers\Maestros\v1\ActualizarDatosAdministradoController;
use App\Http\Controllers\Recursos\v1\RecursosController;
use App\Http\Controllers\Simulaciones\v1\SimulationController;
use App\Http\Controllers\Tramites\v1\TramitesController;
use App\Http\Controllers\Upload\v1\UploadDocumentsController;
use App\Http\Controllers\MesaPartes\v1\MesaPartesController;
use App\Http\Controllers\Notificaicones\auth\v1\NotificationAuthController;

use App\Http\Controllers\Aportes\AportesController;
use App\Http\Controllers\Creditos\EstadoDeCuentaController;
use App\Http\Controllers\FileEntities\FileEntityController;
use App\Http\Controllers\Preguntas\HelpQuestionsController;

Route::post('/auth/register', [RegisterUserController::class,'register'])->name('register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/send-reset-password',[ForgotPasswordController::class,'sendResetLinkResponse']);
Route::post('/auth/resolve-reset-password',[ForgotPasswordController::class,'sendResetResponse']);

Route::group(['middleware' => ['jwt.verify'],
                'prefix' => 'auth'], function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');

});
Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'maestros'], function() {
    Route::post('update-data-admin-and-beneficiaries',[ActualizarDatosAdministradoController::class,'storeAndUpdate']);
   // Route::post('update-data-admin',[ActualizarDatosAdministradoController::class,'store']);
    Route::put('update-data-admin/{id}',[ActualizarDatosAdministradoController::class,'update']);
    Route::get('beneficiarios',[ActualizarDatosAdministradoController::class,'index']);
});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'recursos'], function() {
    Route::get('departamentos',[RecursosController::class,'getDpto']);
    Route::get('provincias/{id}',[RecursosController::class,'getProv']);
    Route::get('distritos/{id}',[RecursosController::class,'getDis']);

    Route::get('grados',[RecursosController::class,'getGrados']);
    Route::get('situaciones',[RecursosController::class,'getSituaciones']);
    Route::get('estados-civiles',[RecursosController::class,'getEstadosCiviles']);
    Route::get('entidades-de-pagos',[RecursosController::class,'getEntidadPagos']);
    Route::get('sexos',[RecursosController::class,'getSexos']);
    Route::get('parentescos',[RecursosController::class,'getParentescos']);
    Route::get('tipo-ext-docs',[RecursosController::class,'getTipoFormatDoc']);
    Route::get('tipos-tramites-digitales',[RecursosController::class,'getTiposTramitesDig']);
    Route::get('sub-tipos-tramites-digitales/{id}',[RecursosController::class,'SubTipoTramite']);



});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'simulaciones'], function() {

    Route::get('simulations',[SimulationController::class,'getAllSimulationUserAuth']);
    Route::get('maximum-capacity',[SimulationController::class,'capacidadMaxima']);
    Route::post('simulation',[SimulationController::class,'simularPrestamo']);

});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'tramites'], function() {
    Route::get('mis-tramites',[TramitesController::class,'getPorcentajeMisTramites']);
});


Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'aportes'], function() {
    Route::get('aporte-por-anno/{year}',[AportesController::class,'getAporteYear']);
    Route::get('aporte-por-anno-detalle/{year}',[AportesController::class,'getAporteDetailYear']);
    Route::get('aporte-all',[AportesController::class,'getAporteAll']);
});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'creditos'], function() {
    Route::get('estados-de-cuenta',[EstadoDeCuentaController::class,'getEstadosCuenta']);
    Route::get('estados-de-cuenta/{id}',[EstadoDeCuentaController::class,'show']);
    Route::get('estados-de-cuenta/{CreditId}/{pagoId}',[EstadoDeCuentaController::class,'getShowPagoDetail']);
    Route::get('estados-de-cuenta-ultimos-movimientos/{id}', [EstadoDeCuentaController::class,'ultimosPagos']);

});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'ultimos'], function() {
    Route::get('movimientos',[EstadoDeCuentaController::class,'ultimosMovimientos']);
});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'uploads'], function() {
    Route::get('uploads-document',[UploadDocumentsController::class,'index']);
    Route::get('uploads-document/{id}',[UploadDocumentsController::class,'show'])->name('uploads-document');
    Route::post('uploads-document',[UploadDocumentsController::class,'store']);
});


Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'virtual_parts'], function() {
    Route::post('virtual_parts_store',[MesaPartesController::class,'store']);

});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'file_entities'], function() {
    Route::post('documents',[FileEntityController::class,'store']);
    Route::get('documents',[FileEntityController::class,'index']);
});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'help_questions'], function() {
    Route::get('questions',[HelpQuestionsController::class,'index']);
    Route::post('questions',[HelpQuestionsController::class,'store']);
});
Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'emails'], function() {
    Route::get('credentials',[\App\Http\Controllers\Mail\MailController::class,'getCredentialsEmails']);
});

Route::group(['middleware' => ['jwt.verify'],
    'prefix' => 'notifications'], function() {
    Route::get('notification',[NotificationAuthController::class,'getMisNotificaiones']);
    Route::put('notification/{id}',[NotificationAuthController::class,'readAuth']);
    Route::get('notifications',[NotificationAuthController::class,'getMisAllNotificaiones']);
});