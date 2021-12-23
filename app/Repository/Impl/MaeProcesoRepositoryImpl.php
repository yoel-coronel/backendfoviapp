<?php

namespace App\Repository\Impl;
use App\Models\Oracle\MaeProceso;
use App\Models\Oracle\TrmMovimiento;
use App\Repository\MaeProcesoRepository;

class MaeProcesoRepositoryImpl implements MaeProcesoRepository
{
    protected  $model;
    public function __construct(MaeProceso $maeProceso)
    {
        $this->model = $maeProceso;
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
        // TODO: Implement find() method.
    }

    public function subProcesos($proceso_padre_id)
    {
        return $this->model->with('maeArea')
                ->where('codi_prop_prc',$proceso_padre_id)
                ->where('flag_esta_prc','<>',0)
                ->select('iden_proc_prc','codi_prop_prc','iden_area_are','tiem_demo_prc','orde_secu_prc','secu_esta_prc','nomb_proc_prc')
                ->orderBy('orde_secu_prc','asc')
                ->get();
    }

    public function getMovimientos($nroExp, $proceso_id)
    {
        return TrmMovimiento::with('maeProceso')
                            ->where('iden_expe_trm',$nroExp)
                            ->where('iden_proc_prc',$proceso_id)
                            ->where('flag_esta_mvm','<>',0)
                            ->select('iden_expe_trm','secu_movi_mvm','iden_proc_prc','area_orig_mvm','area_orig_mvm','fech_envi_mvm','fech_rece_mvm','fech_asig_mvm','fech_venc_mvm','flag_situ_mvm')
                            ->get();
    }
}
