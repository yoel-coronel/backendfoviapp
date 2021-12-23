<?php

namespace App\Services\Impl;

use App\Repository\CrdCreditoCuotaRepository;
use App\Repository\CrdCreditoRepository;
use App\Services\CreditoService;


class CreditoServiceImpl implements CreditoService
{
    protected $crdCreditoRepository;
    protected $crdCreditoCuotaRepository;

    public function __construct(CrdCreditoRepository $crdCreditoRepository, CrdCreditoCuotaRepository $crdCreditoCuotaRepository)
    {
        $this->crdCreditoRepository = $crdCreditoRepository;
        $this->crdCreditoCuotaRepository = $crdCreditoCuotaRepository;
    }
    public function getCreditosAuth()
    {
       return $this->crdCreditoRepository->getCreditosAuth();
    }
    public function showCreditoAuth($id)
    {
        return $this->crdCreditoRepository->showCreditoAuth($id);
    }
    public function getCredCuotas($creditId)
    {
        return $this->crdCreditoCuotaRepository->showByCredit($creditId);
    }
    public function getCredPagoDetail($creditId, $pagoId)
    {
        return $this->crdCreditoCuotaRepository->showByPagoDetail($creditId,$pagoId);
    }
}
