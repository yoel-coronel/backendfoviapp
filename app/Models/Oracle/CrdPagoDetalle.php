<?php

namespace App\Models\Oracle;

use Illuminate\Database\Eloquent\Builder;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class CrdPagoDetalle extends Eloquent
{


    protected $table = 'SIFO.CRD_PAGO_DETALLE';
    protected $connection = 'oracle';
    protected $primaryKey = 'iden_cred_ccs';

    public function scopeDebtByCredit(Builder $query, $creditId)
    {
        return $query->where('iden_cred_crd', $creditId)
            ->groupBy('secu_cuot_cuo')
            ->selectRaw('sum(sald_conc_ccc) as debt, secu_cuot_cuo as id')
            ->pluck('debt', 'id');

    }


}
