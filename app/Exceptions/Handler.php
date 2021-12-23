<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {

            return $this->unauthenticated($request, $exception);

        }
        if ($exception instanceof ValidationException) {

            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if ($exception instanceof ModelNotFoundException) {

            $modelo = class_basename($exception->getModel());
            return $this->errorResponse("No existe ninguna instancia del recurso especificado",1,404);
        }
        if ($exception instanceof AuthorizationException) {

            return $this->errorResponse("No posee permisos para ejecutar esta acción",1,403);
        }
        if ($exception instanceof NotFoundHttpException) {

            return $this->errorResponse("No se encontró la URL especificada",1,404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {

            return $this->errorResponse('El método especificado en la petición no es válido',1,405);
        }
        if($exception instanceof RouteNotFoundException){
            return $this->errorResponse('No se encontró la ruta especificada',1,425);
        }
       /* if($exception instanceof \ErrorException){
            return $this->errorResponse("No se puede abrir el flujo para obtener los datos base para la simulación.",1,409);
        }*/
        if ($exception instanceof QueryException) {

            $code = $exception->errorInfo[1];

            if ($code === 1451) {
                return $this->errorResponse("No se puede eliminar de forma permanente el recurso porque está relacionada con algún otro.",1,409);
            }
            if ($code === 1146) {
                return $this->errorResponse("No existe la tabla en el esquema base de datos.",1,409);
            }
            if ($code === 1062) {
                return $this->errorResponse("Ya existe el valor en la tabla",1,409);
            }
            if ($code === 515) {
                return $this->errorResponse("No se permite valores nulos en las columnas de la tabla de DDBB",1,409);
            }


            if ($exception->getCode() == 2002) {
                return $this->errorResponse("No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión",1,503);
            }
            if ($exception instanceof HttpException) {

                return $this->errorResponse($exception->getMessage(),1,404);
            }

            if ($exception instanceof InvalidArgumentException) {

                return $this->errorResponse($exception->getMessage(),1,400);
            }


        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        return $this->errorResponse("Falla inesperada, intentelo en unos minutos.",1,500);


    }
}
