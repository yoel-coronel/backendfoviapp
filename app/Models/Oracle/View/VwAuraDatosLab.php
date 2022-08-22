<?php

namespace App\Models\Oracle\View;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class VwAuraDatosLab extends  Eloquent
{
    protected $table = "SIFO.VW_AURA_DATOS_LAB";
    protected $connection = 'oracle';
    protected $primaryKey= 'idpers';

}
