<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface QueryMigrateSqlOracleService
{
    public function migraInformationTheSQLOracle(Collection $filters,int $asistencia, $fecta):void;
    public function getDataInformationSQL(array $dnis,$fecha):Collection;
}