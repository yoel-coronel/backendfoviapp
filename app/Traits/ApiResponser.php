<?php

namespace App\Traits;

use App\Http\Resources\UserResource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 *
 */
trait ApiResponser
{

	private function successResponse($data,$code)
	{
		return response()->json($data,$code);
	}
	protected function successResponseStatus($message,$error=0,$code=200){
		return response()->json(['messages'=>$message,'error'=>$error,'code'=>$code],$code);
	}

	protected function errorResponse($message,$error=1,$code=500)
	{
		return response()->json(['messages'=>$message,'error'=>$error,'code'=>$code],$code);
	}
    protected function errorResponseFails(Collection $collection, $error = 1,$code = 400)
    {
        return $this->successResponse(['errors'=>$collection,'error'=>$error,'code'=>$code], $code);
    }
	protected function showAll(Collection $collection, $error = 0,$code = 200)
	{
		return $this->successResponse(['data'=>$collection,'error'=>$error,'code'=>$code], $code);
	}
	protected function showOne(Model $instance, $error = 0, $code=200)
	{
		return $this->successResponse(['data'=>$instance,'error'=>$error,'code'=>$code], $code);
    }
    protected function autoCoplete($numero,$longitud){
        $i = strlen($numero)+1;
        $cadena = $numero;
        while ($i<= $longitud) { $cadena = '0'.$cadena;$i++;}
        return strval($cadena);
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'person' => UserResource::make(auth()->user()),
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
