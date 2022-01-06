<?php

namespace App\Services\Impl;

use App\Repository\MaeEmpresaRepository;
use App\Repository\MaeEntidaddetRepository;
use App\Repository\MaeUbigeoRepository;
use App\Services\RecursosService;
use Illuminate\Support\Collection;

class RecursosServiceImpl implements RecursosService
{
    protected $maeEntidaddetRepository;
    protected $ubigeoRepository;
    protected $maeEmpresaRepository;

    public function __construct(
        MaeEntidaddetRepository $maeEntidaddetRepository,
        MaeUbigeoRepository $ubigeoRepository,
        MaeEmpresaRepository $maeEmpresaRepository
    )
    {
        $this->maeEntidaddetRepository = $maeEntidaddetRepository;
        $this->ubigeoRepository = $ubigeoRepository;
        $this->maeEmpresaRepository = $maeEmpresaRepository;
    }

    public function getConstantEntityForCode($code)
    {
        return $this->maeEntidaddetRepository->getConstantEntityForCode($code);
    }

    public function getConstantEntityForCodeAndSequence($code, $secu)
    {
        return $this->maeEntidaddetRepository->getConstantEntityForCodeAndSequence($code,$secu);
    }

    public function getGrados()
    {
        return $this->maeEntidaddetRepository->getGrados();
    }

    public function getSituaciones()
    {
        return $this->maeEntidaddetRepository->getSituaciones();
    }

    public function getEstadosCiviles()
    {
        return $this->maeEntidaddetRepository->getEstadosCiviles();
    }

    public function getEntidadPagos()
    {
        return $this->maeEntidaddetRepository->getEntidadPagos();
    }

    public function getSexos()
    {
        return $this->maeEntidaddetRepository->getSexos();
    }

    public function getParentescos()
    {
        return $this->maeEntidaddetRepository->getParentescos();
    }

    public function getDepartamentos()
    {
        return $this->ubigeoRepository->getDepartamentos();
    }

    public function getProvincias($id)
    {
        return $this->ubigeoRepository->getProvincias($id);
    }

    public function getDistritos($id)
    {
        return $this->ubigeoRepository->getDistritos($id);
    }

    public function getPTypeDoc()
    {
        return $this->maeEntidaddetRepository->getPTypeDoc();
    }

    public function getTiposTramitesDig()
    {
        return $this->maeEntidaddetRepository->getTiposTramitesDig();
    }


    public function getEmpresas():Collection
    {
        return $this->maeEmpresaRepository->getEmpresas()->map(function ($item){
            return [
                'id' => $item->iden_empr_emp,
                'nombre' => $item->razo_soci_emp,
                'direccion' =>$item->desc_dire_emp,
                'nombre_comercial' => $item->nomb_come_emp,
                'ruc' => $item->nume_ruc_emp
            ];
        });
    }
}
