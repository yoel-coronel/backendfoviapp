<?php

namespace App\Repository;

interface VwAuraCreditoSocioRepository
{
    public function findTramite($trmId);

    public function findPersonaPorTramiteId($trmId);
}