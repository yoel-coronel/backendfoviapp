<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class TrmDocumento extends Eloquent
{
    protected $table = 'SIFO.trm_documento';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_expe_trm';

    //public $timestamps = false;
}
