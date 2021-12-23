<?php

namespace App\Repository;

interface MaeProcesoRepository extends BaseRepository
{
    public function subProcesos($proceso_padre_id);
    public function getMovimientos($nroExp,$proceso_id);
}
