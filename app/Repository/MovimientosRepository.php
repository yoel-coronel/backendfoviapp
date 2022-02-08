<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface MovimientosRepository
{
    public function ultimosMovimientos($idenpers, $numFilas);
}