<?php

namespace App\Models\Digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaeSocio extends Model
{

    use SoftDeletes;

    protected $connection = "sqlsrv2";

    protected $fillable = [
            'iden_pers_per',
            'nomb_comp_per',
            'nume_iden_per',
            'corr_elec_per',
            'nume_celu_per',
            'codi_ccip_soc',
            'codi_cdfi_soc',
            'codi_depa_soc',
            'codi_prov_soc',
            'codi_dist_soc',
            'codi_dire_soc'
    ];

    public function kardexs(){

        return $this->hasMany(Kardex::class);

    }

}
