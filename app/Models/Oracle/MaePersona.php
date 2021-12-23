<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaePersona extends Eloquent
{
    protected $table = 'SIFO.MAE_PERSONA';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_pers_per';

    protected $fillable = ['fech_naci_per'];

    public function socio(){
        return $this->belongsTo(MaeSocio::class,'iden_pers_per','iden_pers_per')->where('flag_esta_soc','<>',0);
    }

}
