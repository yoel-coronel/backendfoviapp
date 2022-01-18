<?php

namespace App\Repository\Impl;

use App\Models\Oracle\TrmTramite;
use App\Models\Oracle\View\VwAuraCreditoSocio;
use App\Repository\TrmTramiteRepository;
use Illuminate\Support\Collection;

class TrmTramiteRepositoryImpl implements TrmTramiteRepository
{
    protected $model;

    public function __construct(TrmTramite $trmTramite)
    {
        $this->model = $trmTramite;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
    public function misTramites($persona_id): Collection
    {
        return $this->model->with('maeProceso')
            ->where('codi_pers_trm',$persona_id)
            ->where('tipo_tram_trm',4)
            ->select('iden_expe_trm','nume_guia_trm','tipo_tram_trm','codi_moda_trm','iden_proc_prc','codi_pers_trm','nomb_tram_trm','desc_asun_trm','fech_ingr_trm','nume_dias_trm','fech_venc_trm','iden_tram_trm','flag_esta_trm','flag_dema_trm')
            ->get();
    }

    public function findTramite($trmId)
    {
        // TODO: Implement findTramite() method.
    }
}
