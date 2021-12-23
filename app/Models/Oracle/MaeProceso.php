<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeProceso extends Eloquent
{
    protected $table = 'SIFO.MAE_PROCESO';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_proc_prc';

    public function maeArea()
    {
        return $this->belongsTo(MaeArea::class, 'iden_area_are', 'iden_area_are')->select('iden_area_are','desc_area_are');
    }

}
