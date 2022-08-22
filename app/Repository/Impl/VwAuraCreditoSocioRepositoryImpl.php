<?php

namespace App\Repository\Impl;

use App\Models\Oracle\View\VwAuraCreditoSocio;
use App\Models\Oracle\View\VwAuraPrestAseini;
use App\Repository\VwAuraCreditoSocioRepository;

class VwAuraCreditoSocioRepositoryImpl implements VwAuraCreditoSocioRepository
{
    protected $model;

    protected $model_view;

    public function __construct(VwAuraCreditoSocio $vwAuraCreditoSocio, VwAuraPrestAseini $vwAuraPrestAseini)
    {
        $this->model = $vwAuraCreditoSocio;
        $this->model_view = $vwAuraPrestAseini;
    }
    public function findTramite($trmId)
    {
        return $this->model->with('persona','socio')->where('iden_expe_trm',$trmId)->where('secu_cred_crd',VwAuraCreditoSocio::maxSecuCrdCrd($trmId))->first();
    }

    public function findPersonaPorTramiteId($trmId)
    {
        return $this->model_view->with('persona','trabajo')->where('iden_expe_trm',$trmId)->first();
    }
}