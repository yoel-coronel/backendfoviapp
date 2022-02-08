<?php

namespace App\Services\Impl;

use App\Repository\CrdCreditoCuotaRepository;
use App\Repository\CrdCreditoRepository;
use App\Repository\MovimientosRepository;
use App\Services\CreditoService;


class CreditoServiceImpl implements CreditoService
{
    protected $crdCreditoRepository;
    protected $crdCreditoCuotaRepository;
    /**
     * @var MovimientosRepository
     */
    private $movimientosRepository;

    public function __construct(CrdCreditoRepository $crdCreditoRepository, 
                                CrdCreditoCuotaRepository $crdCreditoCuotaRepository,
                                MovimientosRepository $movimientosRepository)
    {
        $this->crdCreditoRepository = $crdCreditoRepository;
        $this->crdCreditoCuotaRepository = $crdCreditoCuotaRepository;
        $this->movimientosRepository = $movimientosRepository;
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

    public function getUltimosMovimientos($idenpers, $numFilas)
    {
        return $this->movimientosRepository->ultimosMovimientos($idenpers, $numFilas);
    }
}
