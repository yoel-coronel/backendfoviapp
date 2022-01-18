<?php

namespace App\Repository\Impl;

use App\Models\Oracle\MaeUbigeo;
use App\Repository\MaeUbigeoRepository;

class MaeUbigeoRepositoryImpl implements MaeUbigeoRepository
{
    protected $model;

    /**
     * MaeUbigeoRepositoryImpl constructor.
     *
     * @param MaeUbigeo $maeUbigeo
     */
    public function __construct(MaeUbigeo $maeUbigeo)
    {
        $this->model = $maeUbigeo;
    }

    public function getDepartamentos()
    {
        return $this->model->where('flag_esta_ubi',1)->where('nive_ubig_ubi',1)->select('iden_ubig_ubi','nomb_ubig_ubi')->OrderBy('iden_ubig_ubi','asc')->get();
    }

    public function getProvincias($id)
    {
        return $this->model->where('flag_esta_ubi',1)->where('nive_ubig_ubi',2)->where('iden_ubip_ubi',$id)->select('iden_ubig_ubi','nomb_ubig_ubi')->OrderBy('iden_ubig_ubi','asc')->get();
    }

    public function getDistritos($id)
    {
        return  $this->model->where('flag_esta_ubi',1)->where('nive_ubig_ubi',3)->where('iden_ubip_ubi',$id)->select('iden_ubig_ubi','nomb_ubig_ubi')->OrderBy('iden_ubig_ubi','asc')->get();
    }

    public function findUbigeo($dist_id)
    {
        $dist = $this->model->where('flag_esta_ubi',1)->where('iden_ubig_ubi',$dist_id)->select('iden_ubig_ubi','nomb_ubig_ubi','iden_ubip_ubi')->first();
        $prov = $this->model->where('flag_esta_ubi',1)->where('iden_ubig_ubi',$dist->iden_ubip_ubi)->select('iden_ubig_ubi','nomb_ubig_ubi','iden_ubip_ubi')->first();
        $depa = $this->model->where('flag_esta_ubi',1)->where('iden_ubig_ubi',$prov->iden_ubip_ubi)->select('iden_ubig_ubi','nomb_ubig_ubi','iden_ubip_ubi')->first();

        return [
            'dist_id'=> (string) optional($dist)['iden_ubig_ubi'],
            'prov_id'=> (string)  optional($prov)['iden_ubig_ubi'],
            'depa_id'=> (string) optional($depa)['iden_ubig_ubi']
        ];
    }
}
