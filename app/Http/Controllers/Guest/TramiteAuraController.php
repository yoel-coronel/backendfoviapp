<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Services\TramiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TramiteAuraController extends Controller
{

    /**
     * @var TramiteService
     */
    private $service;

    public function __construct(TramiteService $service)
    {
        $this->service = $service;
    }

    public function findTramite(Request $request,$trmId){

        $rules = [
            'token' =>'required'
        ];

        $validated = Validator::make($request->all(),$rules);

        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        if (!Hash::check($request->token, config('app.key_sifo'))){
            return $this->errorResponseFails(collect(["Las credenciales no son correctas."]),1,401);
        }
        $tramite = $this->service->findTramite($trmId);
        if($tramite){
            return $this->showAll(
                collect(
                    $this->service->findTramite($trmId)
                )
            );
        }else{

            return $this->errorResponse("No se encontró resultados con el Nro de trámite: {$trmId}",1,400);

        }

    }
    
}
