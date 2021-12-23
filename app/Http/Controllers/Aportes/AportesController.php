<?php

namespace App\Http\Controllers\Aportes;

use App\Http\Controllers\Controller;
use App\Services\AporteService;
use Illuminate\Http\Request;

class AportesController extends Controller
{
    protected $aporteService;

    public function __construct(AporteService $aporteService)
    {
        $this->aporteService = $aporteService;
    }
    public function getAporteYear($year){
      $aporte =  $this->aporteService->getAporteAuthYear(optional(auth()->user())->toArray(),$year);
      if($aporte){
          return $this->showAll(collect($aporte));
      }
      return $this->errorResponse(collect('No hay resultados'),1,404);
    }
    public function getAporteDetailYear($year){
        $aportes =  $this->aporteService->getAporteAuthDetailYear(optional(auth()->user())->toArray(),$year);
        if($aportes){
            return $this->showAll(collect($aportes));
        }
        return $this->errorResponse(collect('No hay resultados'),1,404);
    }
    public function getAporteAll(){
        $aportes =  $this->aporteService->getAporteAuthAll(optional(auth()->user())->toArray());
        if($aportes){
            return $this->showAll(collect($aportes));
        }
        return $this->errorResponse(collect('No hay resultados'),1,404);
    }

}
