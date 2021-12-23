<?php

namespace App\Services;

interface CreditoService
{
    public function getCreditosAuth();
    public function showCreditoAuth($id);
    public function getCredCuotas($creditId);
    public function getCredPagoDetail($creditId, $pagoId);
}
