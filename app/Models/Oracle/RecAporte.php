<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class RecAporte extends Eloquent
{
    protected $table = 'SIFO.REC_APORTE';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_apor_apo';

    public function maePersona()
    {
        return $this->belongsTo(MaePersona::class,'iden_pers_per', 'iden_pers_per');
    }
}
