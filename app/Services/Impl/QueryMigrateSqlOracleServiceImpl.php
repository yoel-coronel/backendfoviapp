<?php

namespace App\Services\Impl;

use App\Repository\QueryMigrateMarcacionRepository;
use Illuminate\Support\Collection;
use App\Services\QueryMigrateSqlOracleService;

class QueryMigrateSqlOracleServiceImpl implements QueryMigrateSqlOracleService
{

    /**
     * @var QueryMigrateMarcacionRepository
     */
    private $migrateMarcacionRepository;

    public function __construct(QueryMigrateMarcacionRepository $migrateMarcacionRepository)
    {

        $this->migrateMarcacionRepository =$migrateMarcacionRepository;

    }


    public function migraInformationTheSQLOracle(Collection $filters,int $asistencia,$fecha): bool
    {
        try {

            $dnis = $filters->map(function ($item){return $item['dni'];});
            $datos = $this->getDataInformationSQL($dnis->toArray(),$fecha);
           /* if($datos->count()>0){*/
                $dnis_filtrados = $datos->map(function ($item){return $item->emp_code;});
                $datos_para_acutalizar = $filters->whereIn('dni',$dnis_filtrados);
                if($dnis->count()>0){

                    $info = $datos_para_acutalizar->map(function ($item) use ($datos){
                        return [
                            collect($item)->put('fecha_hora',optional($datos->whereIn('emp_code',$item['dni'])->first())->punch_time),
                        ];
                    })->collapse()->values();
                    $this->migrateMarcacionRepository->migraInformationTheSQLOracle($info->toArray(),$asistencia);
                }
                return true;
            /*}else{
                return false;
            }*/
        }catch (\Exception $exception){
            \Log::error("Error:". $exception->getMessage());
        }

    }

    public function getDataInformationSQL(array $dnis,$fecha): Collection
    {
        return $this->migrateMarcacionRepository->getDataInformationSQL($dnis,$fecha);
    }

    public function executeRunBatch(int $iden_plan_pla): void
    {
        $this->migrateMarcacionRepository->executeRunBatch($iden_plan_pla);
    }
}