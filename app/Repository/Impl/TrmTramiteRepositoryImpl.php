<?php

namespace App\Repository\Impl;

use App\Models\Oracle\TrmTramite;
use App\Models\Oracle\View\VwAuraCreditoSocio;
use App\Repository\TrmTramiteRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrmTramiteRepositoryImpl implements TrmTramiteRepository
{
    protected $model;

    public function __construct(TrmTramite $trmTramite)
    {
        $this->model = $trmTramite;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
    public function misTramites($persona_id): Collection
    {
        return $this->model->with('maeProceso')
            ->where('codi_pers_trm',$persona_id)
            ->where('tipo_tram_trm',4)
            ->select('iden_expe_trm','nume_guia_trm','tipo_tram_trm','codi_moda_trm','iden_proc_prc','codi_pers_trm','nomb_tram_trm','desc_asun_trm','fech_ingr_trm','nume_dias_trm','fech_venc_trm','iden_tram_trm','flag_esta_trm','flag_dema_trm')
            ->get();
    }

    public function findTramite($trmId)
    {
        // TODO: Implement findTramite() method.
    }

    public function getAdministradoCipOrDNI($doc)
    {

        $results =  DB::connection('oracle')->table('SIFO.MAE_SOCIO as s')
            ->join('SIFO.MAE_PERSONA as p ','s.iden_pers_per','=','p.iden_pers_per')
            ->where('s.codi_ccip_soc',$doc)
            ->orWhere('p.nume_iden_per',$doc)
            ->select('p.iden_pers_per','p.nomb_comp_per','p.nume_iden_per','p.corr_elec_per','p.nume_celu_per','s.codi_ccip_soc','s.codi_cdfi_soc','p.flag_esta_per')
            ->get();
        if ($results->count()>0){
            return $results->where('flag_esta_per','<>',0)->first();
        }else{
            return null;
        }

    }

    public function getTramites($itenpers)
    {
        return DB::connection('oracle')
            ->select("SELECT 
					 C.NRODNI,
					 C.IDEN_CRED_CRD,
					 C.IDEN_EXPE_TRM,
					 C.IDEN_PERA_TRM,
					 C.NOMB_TRAM_TRM,
					 --C.IDEN_EXPE_TRM,
					 C.NOMB_PROD_PRD,
					 TRM.FECH_INGR_TRM,
					 NVL(TRM.EXPE_NUME_TRM,
					 NVL((SELECT EP.C_T_MIGRACION FROM SAB.S10EXP EP WHERE EP.C_T_MIGRACION IS NOT NULL AND EP.C_C_EXPEDIENTE=TRM.CODI_EXPE_TRM),TRM.CODI_EXPE_TRM)
					 ) AS CODI_EXPE_TRM,
					 CRD.IDEN_PROD_PRD,
					 (SELECT D.VALO_CADU_DET FROM SIFO.MAE_ENTIDADDET D 
									WHERE D.CODI_ENTI_ENT='CODILINEPRD' 
									AND D.SECU_ENTI_DET = (SELECT P.CODI_LINE_PRD FROM SIFO.MAE_PRODUCTO P WHERE P.IDEN_PROD_PRD = CRD.IDEN_PROD_PRD)) AS LINEA,
					
					(SELECT D.VALO_CADT_DET FROM SIFO.MAE_ENTIDADDET D 
									WHERE D.CODI_ENTI_ENT='CODILINEPRD' 
									AND D.SECU_ENTI_DET = (SELECT P.CODI_LINE_PRD FROM SIFO.MAE_PRODUCTO P WHERE P.IDEN_PROD_PRD = CRD.IDEN_PROD_PRD)) AS SIGLA                                
									
					 FROM       SIFO.VW_AURA_CREDITO_SOCIO C
					 INNER JOIN SIFO.CRD_CREDITO CRD ON C.IDEN_CRED_CRD = CRD.IDEN_CRED_CRD
					 INNER JOIN SIFO.TRM_TRAMITE TRM ON C.IDEN_EXPE_TRM = TRM.IDEN_EXPE_TRM
					 WHERE      C.SECU_CRED_CRD =(SELECT MAX(T.SECU_CRED_CRD) FROM SIFO.VW_AURA_CREDITO_SOCIO T WHERE T.IDEN_EXPE_TRM=C.IDEN_EXPE_TRM)
					 AND        C.IDEN_PERA_TRM=?",[$itenpers]);

    }
}
