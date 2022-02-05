<?php

namespace App\Models\Oracle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class RhuAsistenciaDetalle extends Eloquent
{
    use HasFactory;

    protected $table = 'SIFO.RHU_ASISTENCIA_DETALLE';

    protected $connection = 'oracle';

    public $timestamps = false;

    protected $primaryKey = false;

}
