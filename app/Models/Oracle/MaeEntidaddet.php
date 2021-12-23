<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeEntidaddet extends Eloquent
{
    protected $table = 'SIFO.MAE_ENTIDADDET';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_enti_det';
}
