<?php

namespace App\Repository\Impl;

use App\Models\Oracle\View\VwAuraCreditoSocio;
use App\Repository\VwAuraCreditoSocioRepository;

class VwAuraCreditoSocioRepositoryImpl implements VwAuraCreditoSocioRepository
{
    protected $model;

    public function __construct(VwAuraCreditoSocio $vwAuraCreditoSocio)
    {
        $this->model = $vwAuraCreditoSocio;
    }
    public function findTramite($trmId)
    {
        return $this->model->with('persona','socio')->where('iden_expe_trm',$trmId)->where('secu_cred_crd',VwAuraCreditoSocio::maxSecuCrdCrd($trmId))->first();
    }
}