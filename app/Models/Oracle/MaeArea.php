<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeArea extends Eloquent
{

    protected $table = 'SIFO.MAE_AREA';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_area_are';

}
