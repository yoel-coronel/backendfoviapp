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
              return DB::connection('sqlsrv1')->table('ICLOCK_TRANSACTION')
                ->select('emp_code',
                                    DB::raw('MIN(punch_time) AS punch_time'),
                                    DB::raw('CONVERT(CHAR(10), MIN(punch_time), 103) AS fecha'),
                                    DB::raw('CONVERT(CHAR(8), MIN(punch_time), 108) AS hora'))
                ->whereIn(DB::raw("(REPLICATE('0',8-LEN(emp_code))+ emp_code )"), $dnis)
                ->whereDate('punch_time',$fecha)
                ->groupBy('emp_code')
                ->get();

        //return IclockTransaction::whereDate('punch_time',$fecha)->whereIn('emp_code',$dnis)->get();
    }


    public function executeRunBatch(int $iden_plan_pla): void
    {
        try {
                DB::connection('oracle')->beginTransaction();

                $detalles = new Collection();
                $detalles = $this->getRecPlanillaDet($iden_plan_pla);
                foreach ($detalles as $key => $value){
                    $admin = $this->getDataDirrehum($value->cip);
                    try {
                        DB::connection('oracle')->select('begin SIFO.PKG_MI_FOVIPOL.p_uppdate_situacion(?,?,?,?); end;',
                            array($value->id,intval($admin['administrado']['codsituacion']),$admin['administrado']['codsituacion'],$admin['administrado']['situacion']));
                    }catch (\Exception $exception){
                        \Log::error($exception->getMessage());
                    }

                }
                DB::connection('oracle')->select('begin SIFO.PKG_MI_FOVIPOL.p_update_run_batch(?); end;', array($iden_plan_pla));
                DB::connection('oracle')->commit();
            }catch (\Exception $exception){
                \Log::error($exception->getMessage());
                DB::connection('oracle')->rollBack();
            }

    }

    private function getRecPlanillaDet($iden_plan_pla):Collection{
        return collect(DB::connection('oracle')
                                        ->select("SELECT T.IDEN_PLAN_RPD as id ,T.IDEN_PERS_PER as idper, T.IDEN_PLAN_PLA as idpla,S.CODI_CCIP_SOC as cip
                                                         FROM SIFO.REC_PLANILLA_DET t INNER JOIN SIFO.MAE_SOCIO S ON S.IDEN_PERS_PER = T.IDEN_PERS_PER
                                                         WHERE t.iden_plan_pla = ? AND t.flag_esta_rpd<>?",[$iden_plan_pla,0]));
    }
    private function getDataDirrehum($cip){

            return json_decode(file_get_contents(config("app.url_simulation")."/api/externos/dirrehum/requestByCip?strIp=192.168.10.36&strMac=?&strHost=?&strUsuario=lbellido&strCip=$cip&intAuditar=0&strSistema=SIFO&strTipoconsulta=EXT"), true );
    }

}