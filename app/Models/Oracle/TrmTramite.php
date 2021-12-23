<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class TrmTramite extends Eloquent
{
    protected $table = 'SIFO.TRM_TRAMITE';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_expe_trm';

    public function maePersona()
    {
        return $this->belongsTo(MaePersona::class, 'codi_pers_trm','iden_pers_per')
            ->where('flag_esta_per','<>',0);
    }

     public function maeProceso()
     {
         return $this->belongsTo(MaeProceso::class, 'iden_proc_prc', 'iden_proc_prc')
             ->where('flag_esta_prc','<>',0)
             ->select('iden_proc_prc','codi_prop_prc','iden_area_are','tiem_demo_prc','orde_secu_prc','secu_esta_prc','nomb_proc_prc');
     }
     public function trmMovimientos()
     {
         return $this->hasMany(TrmMovimiento::class, 'iden_expe_trm', 'iden_expe_trm')
             ->where('flag_esta_mvm','<>',0)->orderBy('secu_movi_mvm');
     }

     /*public function documentos()
     {
         return $this->hasMany(TrmDocumento::class, 'iden_expe_trm', 'iden_expe_trm')->where('flaf_subi_doc',1)->orderBy('secu_docu_doc');
     }
     */

}
