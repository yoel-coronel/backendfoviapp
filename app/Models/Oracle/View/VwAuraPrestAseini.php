<?php

namespace App\Models\Oracle\View;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class VwAuraPrestAseini extends  Eloquent
{
    protected $table = "SIFO.VW_AURA_PREST_ASEINI";
    protected $connection = 'oracle';
    protected $primaryKey= 'iden_expe_trm';

    public function persona()
    {
        return $this->hasOne(VwAuraDatosPersonales::class, 'idpers', 'idpers')->with('conyuge');
    }
    public function trabajo()
    {
        return $this->hasOne(VwAuraDatosLab::class, 'idpers', 'idpers');
    }

}
