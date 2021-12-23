<?php

namespace App\Repository;

interface CrdCreditoCuotaRepository
{
    public function showByCredit($credito_id);
    public function showByPagoDetail($creditId,$pagoId);
}
