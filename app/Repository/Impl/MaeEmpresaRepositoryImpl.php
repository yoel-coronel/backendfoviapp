<?php

namespace App\Repository\Impl;
use App\Models\Oracle\MaeEmpresa;
use App\Repository\MaeEmpresaRepository;
use Illuminate\Support\Collection;


class MaeEmpresaRepositoryImpl implements MaeEmpresaRepository
{
    protected $model;

    public function __construct(MaeEmpresa $empresa)
    {
        $this->model = $empresa;
    }

    public function getEmpresas(): Collection
    {
        return $this->model->select('iden_empr_emp','razo_soci_emp','desc_dire_emp','nomb_come_emp','nume_ruc_emp','flag_esta_emp')->where('giro_nego_emp',9)->where('flag_esta_emp','<>',0)->get();
    }
}