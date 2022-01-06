<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface MaeEmpresaRepository
{
    public function getEmpresas():Collection;
}