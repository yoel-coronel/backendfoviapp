<?php

namespace App\Models\Oracle\View;

use App\Models\Oracle\MaePersona;
use App\Models\Oracle\MaeSocio;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class VwAuraCreditoSocio extends  Eloquent
{
    protected $table = "SIFO.VW_AURA_CREDITO_SOCIO";
    protected $connection = 'oracle';
    protected $primaryKey= null;

    public static function maxSecuCrdCrd($trmId){
        return VwAuraCreditoSocio::where('iden_expe_trm',$trmId)->where('flag_cred_crd',1)->max('secu_cred_crd');
    }
    public function persona()
    {
        return $this->hasOne(MaePersona::class, 'iden_pers_per', 'iden_pera_trm');
    }
    public function socio()
    {
        return $this->hasOne(MaeSocio::class, 'iden_pers_per', 'iden_pera_trm');
    }

}
