<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\UbugeoCollection;
use App\Services\RecursosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RecursosController extends Controller
{
    protected $service;
    public function __construct(RecursosService $recursosService)
    {
        $this->service = $recursosService;
    }

    public function getEmpresas(Request $request){

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

        return $this->showAll(
            collect(
                $this->service->getEmpresas()
            )
        );

    }

    public function getAreas(Request $request){

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

        return $this->showAll(
            collect(
                $this->service->getAreas()
            )
        );
    }
    public function getDepartamentos(Request $request){

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

        return $this->showAll(collect(UbugeoCollection::make($this->service->getDepartamentos())));
    }
    public function getProvincias(Request $request,$id){
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

        return $this->showAll(collect(UbugeoCollection::make($this->service->getProvincias($id))));
    }
    public function getDistritos(Request $request,$id){
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

        return $this->showAll(collect(UbugeoCollection::make($this->service->getDistritos($id))));
    }

}
