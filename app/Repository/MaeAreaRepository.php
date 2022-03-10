<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface MaeAreaRepository
{
    public function getAreas():Collection;
}