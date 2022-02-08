<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreditoCollection;
use App\Http\Resources\CreditoResource;
use App\Http\Resources\MovimientosCollection;
use App\Services\CreditoService;
use Illuminate\Http\Request;

class EstadoDeCuentaController extends Controller
{
    protected $creditoService;

    public function __construct(CreditoService $creditoService)
    {
        $this->creditoService = $creditoService;
    }
    public function getEstadosCuenta(){
        return $this->showAll(collect(CreditoCollection::make($this->creditoService->getCreditosAuth())));
    }
    public function show($id){

        return  $this->showAll(collect(
            [
            'credito' =>CreditoResource::make($this->creditoService->showCreditoAuth($id)),
            'cuotas' => $this->creditoService->getCredCuotas($id)
        ]));
    }
    public function getShowPagoDetail($creditId,$pagoId){
        return $this->showAll($this->creditoService->getCredPagoDetail($creditId,$pagoId));
    }

    public function ultimosPagos($id){

        return  $this->showAll(collect(
            [
                'credito' =>CreditoResource::make($this->creditoService->showCreditoAuth($id)),
                'cuotas' => collect(optional($this->creditoService->getCredCuotas($id))['data'])
                                    ->where('situation',"PAGADO")
                                    ->sortByDesc('id')
                                    ->take(10)
                                    ->values()
            ]));
    }
    public function ultimosMovimientos(){

        $idenpers = optional(auth()->user())->identifier;
        $numFilas = 10;
        return  $this->showAll(collect(MovimientosCollection::make($this->creditoService->getUltimosMovimientos($idenpers,$numFilas))));
    }
}
