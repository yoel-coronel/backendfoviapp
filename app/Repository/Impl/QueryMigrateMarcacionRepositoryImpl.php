<?php

namespace App\Repository\Impl;
use App\Models\Oracle\RhuAsistenciaDetalle;
use App\Models\Zkbiotime\IclockTransaction;
use App\Repository\QueryMigrateMarcacionRepository;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QueryMigrateMarcacionRepositoryImpl implements QueryMigrateMarcacionRepository
{

    public function migraInformationTheSQLOracle(array $ids, int $asistencia): void
    {

        foreach ($ids as $key=>$value){
            try {
                DB::connection('oracle')->beginTransaction();

                DB::connection('oracle')->table("SIFO.RHU_ASISTENCIA_DETALLE")->where('iden_pers_per',$value['idenpers'])
                    ->where('secu_rehu_asd',$value['secuencia'])
                    ->where('iden_rehu_asi',$asistencia)
                    ->update(
                        ['FECH_REGI_ASD'=>Carbon::parse($value['fecha_hora']),
                        'FECH_MODI_AUD'=>now(),
                        'USUA_MODI_AUD'=>$value['usuario'],
                        'NOMB_EQUI_AUD'=>$value['ip'],
                        'SIOP_DESC_ASD'=>$value['sistema']]
                    );

                $fecha = Carbon::parse($value['fecha_hora']);
                DB::connection('oracle')->select('begin SIFO.PKG_RECURSOS_HUMANOS.sp_actualizar_tardanza(?, ?, ?); end;', array($asistencia,$value['secuencia'],$fecha));
                DB::connection('oracle')->commit();


            }catch (\Exception $exception){
                \Log::error($exception->getMessage());
                DB::connection('oracle')->rollBack();
            }


        }
    }

    public function getDataInformationSQL(array $dnis,$fecha): Collection
    {
        //$fecha = now()->format("Y-m-d");
        return IclockTransaction::whereDate('punch_time',$fecha)->whereIn('emp_code',$dnis)->get();
    }


}