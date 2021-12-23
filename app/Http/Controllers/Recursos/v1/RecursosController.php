<?php

namespace App\Http\Controllers\Recursos\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecursoCollection;
use App\Http\Resources\UbugeoCollection;
use App\Http\Resources\UbugeoResource;
use App\Services\RecursosService;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    protected $recursosService;
    public function __construct(RecursosService $recursosService)
    {
        $this->recursosService = $recursosService;
    }
    public function getDpto(){
        return $this->showAll(collect(UbugeoCollection::make($this->recursosService->getDepartamentos())));
    }
    public function getProv($id){
        return $this->showAll(collect(UbugeoCollection::make($this->recursosService->getProvincias($id))));
    }
    public function getDis($id){
        return $this->showAll(collect(UbugeoCollection::make($this->recursosService->getDistritos($id))));
    }
    public function getGrados()
    {
        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getGrados())));
    }

    public function getSituaciones()
    {
        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getSituaciones())));
    }

    public function getEstadosCiviles()
    {
        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getEstadosCiviles())));
    }

    public function getEntidadPagos()
    {
        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getEntidadPagos())));
    }

    public function getTipoFormatDoc()
    {
        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getPTypeDoc())));
    }

    public function getSexos()
    {
        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getSexos())));
    }

    public function getParentescos()
    {
        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getParentescos())));
    }
    public function getTiposTramitesDig()
    {
        $tipos_trmites = $this->recursosService->getTiposTramitesDig()->map(function ($item){
            return [
                'id' =>(int)$item->secu_enti_det,
                'name' =>$item->valo_cadu_det,
                'description'=>$item->valo_cadd_det,
                'format' =>$item->valo_cadt_det
            ];
        });

        return $this->showAll(collect($tipos_trmites));
    }
    public function SubTipoTramite($secu){

        return $this->showAll(collect(RecursoCollection::make($this->recursosService->getConstantEntityForCodeAndSequence('SUTIPTRMDIG',$secu))));

    }

}
