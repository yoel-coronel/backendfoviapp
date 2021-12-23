<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class TrmMovimiento extends Eloquent
{
    protected $table = 'SIFO.TRM_MOVIMIENTO';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_expe_trm';

    public function maeProceso()
    {
        return $this->belongsTo(MaeProceso::class, 'iden_proc_prc', 'iden_proc_prc')
                ->where('flag_esta_prc','<>',0)
                ->select('iden_proc_prc','codi_prop_prc','iden_area_are','tiem_demo_prc','orde_secu_prc','secu_esta_prc','nomb_proc_prc');
    }

    public function areaOrigen(){
        return $this->belongsTo(MaeArea::class,'area_orig_mvm','iden_area_are');
    }
    public function areaDestino(){
        return $this->belongsTo(MaeArea::class,'area_dest_mvm','iden_area_are');
    }
}
