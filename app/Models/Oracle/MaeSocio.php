<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeSocio extends Eloquent
{
    protected $table = 'SIFO.MAE_SOCIO';

    protected $connection = 'oracle';

    public function persona()
    {
        return $this->hasOne(MaePersona::class, 'iden_pers_per', 'iden_pers_per');
    }

}
