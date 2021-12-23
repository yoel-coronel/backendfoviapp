<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeProducto extends Eloquent
{
    protected $table = 'SIFO.MAE_PRODUCTO';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_prod_prd';
}
