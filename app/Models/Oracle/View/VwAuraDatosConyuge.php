<?php

namespace App\Models\Oracle\View;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class VwAuraDatosConyuge extends  Eloquent
{
    protected $table = "SIFO.VW_AURA_DATOS_CONYUGE";
    protected $connection = 'oracle';
    protected $primaryKey= 'idpers';

}
