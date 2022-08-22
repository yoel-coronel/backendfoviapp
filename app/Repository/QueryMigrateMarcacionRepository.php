<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface QueryMigrateMarcacionRepository
{
    public function migraInformationTheSQLOracle(array $ids,int $asistencia):void;
    public function getDataInformationSQL(array $dnis,$fecha):Collection;
    public function executeRunBatch(int $iden_plan_pla):void;

}