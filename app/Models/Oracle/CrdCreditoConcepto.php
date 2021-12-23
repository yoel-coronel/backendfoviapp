<?php

namespace App\Models\Oracle;

use Illuminate\Database\Eloquent\Builder;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;


class CrdCreditoConcepto extends Eloquent
{
    protected $table = 'SIFO.CRD_CUOTA_CONCEPTO';

    protected $connection = 'oracle';

    public function crdCredito()
    {
        return $this->belongsTo(CrdCredito::class, 'iden_cred_crd', 'iden_cred_crd');
    }
    public function crdPagoDetalle()
    {
        return $this->hasMany(CrdPagoDetalle::class,'iden_pago_rpc','iden_pago_rpc')
                    ->where('flag_esta_ccs','<>',0);
    }
    public function scopeDebtByCredit(Builder $query, $creditId)
    {
        return $query->where('iden_cred_crd', $creditId)
            ->groupBy('secu_cuot_cuo')
            ->selectRaw('sum(sald_conc_ccc) as debt, secu_cuot_cuo as id')
            ->pluck('debt', 'id');
    }
}
