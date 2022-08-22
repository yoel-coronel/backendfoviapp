<?php

namespace App\Models\Oracle\View;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class VwAuraDatosPersonales extends  Eloquent
{
    protected $table = "SIFO.VW_AURA_DATOS_PERSONALES";
    protected $connection = 'oracle';
    protected $primaryKey= 'idpers';

    public function conyuge()
    {
        return $this->hasOne(VwAuraDatosConyuge::class, 'idpers', 'idpers');
    }

}
