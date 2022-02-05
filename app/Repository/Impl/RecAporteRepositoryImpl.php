<?php

namespace App\Repository\Impl;

use App\Models\Oracle\RecAporte;
use App\Repository\RecAporteRepository;
use Illuminate\Support\Facades\DB;

class RecAporteRepositoryImpl implements RecAporteRepository
{
    protected $model;

    public function __construct(RecAporte $recAporte)
    {
        $this->model = $recAporte;
    }

    public function getAporteAuthYear($persona_id,$year)
    {
        return $this->model->select('anio_cobr_apo as anno', DB::raw('SUM(impo_cobr_apo) as total'))
            ->where('anio_cobr_apo',$year)
            ->where('iden_pers_per',$persona_id)
            ->where('tipo_apor_apo',1)
            ->where('flag_esta_apo',1)
            ->groupBy('anio_cobr_apo')
            ->get();
    }

    public function getAporteAuthDetailYear($persona_id,$year)
    {
        return $this->model->select('anio_cobr_apo as anno','nmes_cobr_apo as mes', DB::raw('SUM(impo_cobr_apo) as total'))
            ->where('anio_cobr_apo',$year)
            ->where('iden_pers_per',$persona_id)
            ->where('tipo_apor_apo',1)
            ->where('flag_esta_apo',1)
            ->groupBy('anio_cobr_apo','nmes_cobr_apo')
            ->orderBy('nmes_cobr_apo','asc')
            ->get();
    }

    public function getAporteAuthAll($persona_id)
    {
        return $this->model->select('anio_cobr_apo as anno','nmes_cobr_apo as mes', DB::raw('SUM(impo_cobr_apo) as total'))
            ->where('iden_pers_per',$persona_id)
            ->where('tipo_apor_apo',1)
            ->where('flag_esta_apo',1)
            ->groupBy('anio_cobr_apo','nmes_cobr_apo')
            ->orderBy('anio_cobr_apo','asc')
            ->orderBy('nmes_cobr_apo','asc')
            ->get();
    }

    public function getNivelacionAuthYear($persona_id, $year)
    {
        return $this->model->select('anio_cobr_apo as anno', DB::raw('SUM(impo_cobr_apo) as total'))
            ->where('anio_cobr_apo',$year)
            ->where('iden_pers_per',$persona_id)
            ->where('tipo_apor_apo',3)
            ->where('flag_esta_apo',1)
            ->groupBy('anio_cobr_apo')
            ->get();
    }

    public function getNivelacionAuthDetailYear($persona_id, $year)
    {
        return $this->model->select('anio_cobr_apo as anno','nmes_cobr_apo as mes', DB::raw('SUM(impo_cobr_apo) as total'))
            ->where('anio_cobr_apo',$year)
            ->where('iden_pers_per',$persona_id)
            ->where('flag_esta_apo',1)
            ->where('tipo_apor_apo',3)
            ->groupBy('anio_cobr_apo','nmes_cobr_apo')
            ->orderBy('nmes_cobr_apo','asc')
            ->get();
    }

    public function getNivelacionAuthAll($persona_id)
    {
        return $this->model->select('anio_cobr_apo as anno','nmes_cobr_apo as mes', DB::raw('SUM(impo_cobr_apo) as total'))
            ->where('iden_pers_per',$persona_id)
            ->where('flag_esta_apo',1)
            ->where('tipo_apor_apo',3)
            ->groupBy('anio_cobr_apo','nmes_cobr_apo')
            ->orderBy('anio_cobr_apo','asc')
            ->orderBy('nmes_cobr_apo','asc')
            ->get();
    }
}
