<?php

namespace App\Models\Oracle;

use App\Traits\ConstantEntityScope;
use App\Traits\MultipleJoinScope;
use Illuminate\Database\Eloquent\Builder;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class CrdCreditoCuota extends Eloquent
{

    use ConstantEntityScope, MultipleJoinScope;

    public static $debts;

    protected $table = 'SIFO.CRD_CREDITO_CUOTA';

    protected $connection = 'oracle';

    public function crdCredito()
    {
        return $this->belongsTo(CrdCredito::class, 'iden_cred_crd', 'iden_cred_crd');
    }
    public function situation()
    {
        return $this->constantEntity('codi_situ_cuo');
    }
    public function setDebts($creditId)
    {
        static::$debts = CrdCreditoConcepto::debtByCredit($creditId);
        return $this;
    }
    public function scopeOfByCredit(Builder $query, $creditId)
    {
        $query->where('CRD_CREDITO_CUOTA.flag_esta_cuo', '<>', 0)
            ->where('CRD_CREDITO_CUOTA.iden_cred_crd', $creditId);
    }

}
