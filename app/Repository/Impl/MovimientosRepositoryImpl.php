<?php

namespace App\Repository\Impl;

use App\Repository\MovimientosRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MovimientosRepositoryImpl implements MovimientosRepository
{

    public function ultimosMovimientos($idenpers, $numFilas)
    {

        $movimientos_aportes=  DB::connection("oracle")
                ->select("SELECT * FROM (
                                              SELECT
                                                T.IDEN_PERS_PER AS IDPERS,T.IMPO_COBR_APO AS IMPORTE,'SOLES' AS MONEDA, 
                                               ( SELECT 
                                                (SELECT D.VALO_CADU_DET FROM SIFO.MAE_ENTIDADDET D WHERE D.CODI_ENTI_ENT='CODICANACOB' AND D.SECU_ENTI_DET=TA.CODI_CANA_COB)
                                               FROM SIFO.REC_RECEP_APORTE TA WHERE TA.IDEN_PLAN_REA=T.IDEN_PLAN_REA)  AS ENTIDADPAGO,
                                                'PAGO DE APORTE' AS  CONCEPTO,
                                                TRUNC(TO_DATE(('01'||'/'||T.NMES_COBR_APO||'/'||T.ANIO_COBR_APO),'dd/MM/yyyy')) AS FECHAPAGO
                                               FROM SIFO.REC_APORTE T WHERE T.FLAG_ESTA_APO=1 AND T.TIPO_APOR_APO IN (1,2) AND T.IDEN_PERS_PER=$idenpers --AND ROWNUM < 10
                                               ORDER BY TRUNC(TO_DATE(('01'||'/'||T.NMES_COBR_APO||'/'||T.ANIO_COBR_APO),'dd/MM/yyyy')) DESC
                                            )WHERE ROWNUM < 10 ");

        $movimientos_credidtos =  DB::connection("oracle")
            ->select("SELECT * FROM (    
                               SELECT
                                C.IDEN_PERS_PER AS IDPERS,C.IMPO_PAGO_RPG AS IMPORTE,
                                UPPER((SELECT D.VALO_CADU_DET FROM SIFO.MAE_ENTIDADDET D WHERE D.CODI_ENTI_ENT='CODIMONECRD' AND D.SECU_ENTI_DET=C.CODI_MONE_CRD)) AS MONEDA,
                                (SELECT D.VALO_CADU_DET FROM SIFO.MAE_ENTIDADDET D WHERE D.CODI_ENTI_ENT='ENTIPAGOSOC' AND D.SECU_ENTI_DET=C.ENTI_PAGO_SOC) AS ENTIDADPAGO,
                                'PAGO DE CREDITO' AS  CONCEPTO,
                                TRUNC(C.FECH_PAGO_RPG) AS FECHAPAGO
                               FROM SIFO.REC_PAGO_CUOTA C
                               WHERE C.FLAG_ESTA_RPG<>0 AND C.TIPO_ACCI_PAG=1  AND C.IDEN_PERS_PER=$idenpers --AND ROWNUM < 10
                               ORDER BY TRUNC(C.FECH_PAGO_RPG) DESC
                            )WHERE ROWNUM < 10");

        return array_merge($movimientos_aportes,$movimientos_credidtos);

    }
}