<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeUbigeo extends Eloquent
{
    protected $table = 'SIFO.MAE_UBIGEO';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_ubig_ubi';

}
