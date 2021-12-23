<?php

namespace App\Repository\Impl;

use App\Models\Oracle\CrdCredito;
use App\Repository\CrdCreditoRepository;

class CrdCreditoRepositoryImpl implements CrdCreditoRepository
{
    protected $dataExtended = ['trmTramite', 'creditStatus', 'coin', 'product', 'reasonForCredit'];

    protected $model;

    public function __construct(CrdCredito $crdCredito)
    {
        $this->model = $crdCredito;
    }

    public function getCreditosAuth()
    {
        return $this->model->with($this->dataExtended)->get();
    }
    public function showCreditoAuth($id)
    {
        return $this->model->with($this->dataExtended)->find($id);
    }
}
