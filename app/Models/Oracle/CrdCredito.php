<?php

namespace App\Models\Oracle;


use App\Scope\CreditAvailable;
use App\Scope\ProcedureAuthUserFromRelation;
use App\Scope\ProcedureTypeScopeFromRelation;
use App\Traits\ConstantEntityScope;
use App\Traits\MultipleJoinScope;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class CrdCredito extends Eloquent
{
    use ConstantEntityScope,MultipleJoinScope;

    protected $table = 'SIFO.CRD_CREDITO';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_cred_crd';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(){

        parent::boot();
        // scope global
        // Agrega el id de la persona
        static::addGlobalScope(new ProcedureAuthUserFromRelation());

        // Agrega al query que solo devuelve el tipo 4
        static::addGlobalScope(new ProcedureTypeScopeFromRelation());

        // Agrega filtro para devolver los creditos no deshabilitados y con usen el flag
        // 1,10,12,13
        static::addGlobalScope(new CreditAvailable());

    }

    public function trmTramite()
    {
        return $this->belongsTo(TrmTramite::class, 'iden_expe_trm', 'iden_expe_trm');
    }

    public function crdCreditoCuotas()
    {
        return $this->hasMany(CrdCreditoCuota::class, 'iden_cred_crd', 'iden_cred_crd');
    }

    public function crdCreditoConceptos()
    {
        return $this->hasMany(CrdCreditoConcepto::class, 'iden_cred_crd', 'iden_cred_crd');
    }

    public function creditStatus()
    {
        return $this->constantEntity('flag_cred_crd');
    }
    public function coin()
    {
        return $this->constantEntity('codi_mone_crd');
    }
    public function reasonForCredit()
    {
        return $this->constantEntity('codi_apli_crd');
    }
    public function product()
    {
        return $this->belongsTo(MaeProducto::class,  'iden_prod_prd', 'iden_prod_prd');
    }


}
