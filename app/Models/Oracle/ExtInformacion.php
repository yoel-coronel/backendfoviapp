<?php

namespace App\Models\Oracle;

use Illuminate\Support\Facades\DB;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class ExtInformacion extends Eloquent
{
    protected $table = 'SIFO.EXT_INFORMACION';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_exte_inf';

    protected $fillable = [ 'iden_exte_inf',
                            'iden_pers_per',
                            'nume_iden_per',
                            'apel_pate_per',
                            'apel_mate_per',
                            'nomb_pers_per',
                            'nomb_comp_per',
                            'esta_civi_per',
                            'corr_prin_per',
                            'corr_secu_per',
                            'celu_prin_per',
                            'celu_secu_per',
                            'tlfn_prin_per',
                            'tlfn_secu_per',
                            'ubig_domi_per',
                            'dire_domi_per',
                            'refe_domi_per',
                            'codi_ccip_soc',
                            'codi_cdfi_soc',
                            'codi_caja_soc',
                            'camp_tipo_inf',
                            'fech_crea_aud',
                            'usua_crea_aud',
                            'flag_exte_inf',
                            'iden_extp_inf',
                            'esci_desc_per',
                            'fech_naci_per',
                            'flag_disc_inf',
                            'nume_cona_inf',
                            'iden_expe_trm',
                            'codi_grad_soc',
                            'codi_situ_soc',
                            'fech_baja_soc',
                            'sexo_pers_per',
                            'grad_pare_per',
                            'fech_iesc_soc'
                        ];

    public $timestamps = false;

    public $incrementing = false;

    protected $casts = [
        'fech_crea_aud' => 'datetime'
    ];

    public static function generateKey(){
        $data =  ExtInformacion::orderby('iden_exte_inf','DESC')->take(1)->get();
        if ($data) {
                $Secu = (int) $data->max('iden_exte_inf') + 1;
                DB::connection('oracle')->update('UPDATE SIFO.ADM_SECUENCIA SET GENE_VAL = ? WHERE IDEN_GENE_TAB = ?',[$Secu,'EXT_INFORMACION']);
              return $Secu;
        }
        return 1;
    }
}
