<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeEmpresa extends Eloquent
{
    protected $table = 'SIFO.MAE_EMPRESA';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_empr_emp';

}
