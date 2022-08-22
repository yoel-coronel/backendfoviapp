<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Optional;

class PersonaTramiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'titular' => [
                'idpers' => Optional($this->resource->persona)->idpers,
                'paterno'=> Optional($this->resource->persona)->paterno,
                'materno'=> Optional($this->resource->persona)->materno,
                'nombres'=> Optional($this->resource->persona)->nombres,
                'dni'=> Optional($this->resource->persona)->dni,
                'estado_civil'=> Optional($this->resource->persona)->estado_civil,
                'num_hijos'=> Optional($this->resource->persona)->num_hijos,
                'situacion'=> Optional($this->resource->persona)->situacion,
                'grado'=> Optional($this->resource->persona)->grado,
                'codofin'=> Optional($this->resource->persona)->codofin,
                'cip'=> Optional($this->resource->persona)->cip,
                'fecha_nac'=> Optional($this->resource->persona)->fecha_nac,
                'lugar_nac'=> Optional($this->resource->persona)->lugar_nac,
                'sexo'=> Optional($this->resource->persona)->sexo,
                'celular'=> Optional($this->resource->persona)->celular,
                'correo'=> Optional($this->resource->persona)->correo,
                'direccion'=> trim(Optional($this->resource->persona)->direccion),
                'ubigeo_residencia'=> trim(Optional($this->resource->persona)->ubigeo_residencia)
            ],
            'conyuge' => [
                'idpers' => Optional($this->resource->persona->conyuge)->idpers,
                'idpers_conyuge' => Optional($this->resource->persona->conyuge)->idpers_conyuge,
                'paterno'=> Optional($this->resource->persona->conyuge)->paterno,
                'materno'=> Optional($this->resource->persona->conyuge)->materno,
                'nombres'=> Optional($this->resource->persona->conyuge)->nombres,
                'dni'=> Optional($this->resource->persona->conyuge)->dni,
                'estado_civil'=> Optional($this->resource->persona->conyuge)->estado_civil,
                'num_hijos'=> Optional($this->resource->persona->conyuge)->num_hijos,
                'situacion'=> Optional($this->resource->persona->conyuge)->situacion,
                'grado'=> Optional($this->resource->persona->conyuge)->grado,
                'codofin'=> Optional($this->resource->persona->conyuge)->codofin,
                'cip'=> Optional($this->resource->persona->conyuge)->cip,
                'fecha_nac'=> Optional($this->resource->persona->conyuge)->fecha_nac,
                'lugar_nac'=> Optional($this->resource->persona->conyuge)->lugar_nac,
                'sexo'=>Optional($this->resource->persona->conyuge)->sexo,
                'celular'=> Optional($this->resource->persona->conyuge)->celular,
                'correo'=> Optional($this->resource->persona->conyuge)->correo,
                'direccion'=> trim(Optional($this->resource->persona->conyuge)->direccion),
                'ubigeo_residencia'=>trim(Optional($this->resource->persona->conyuge)->ubigeo_residencia)
            ],
            'labores'=>[
                'idpers' => Optional($this->resource->trabajo)->idpers,
                'cip' => Optional($this->resource->trabajo)->cip,
                'num_trabajo'=> Optional($this->resource->trabajo)->num_trabajo,
                'ubigeo_untrab'=> Optional($this->resource->trabajo)->ubigeo_untrab,
                'ubde_untr_soc'=> Optional($this->resource->trabajo)->ubde_untr_soc,
                'num_corp'=> Optional($this->resource->trabajo)->num_corp,
                'correo_corp'=> Optional($this->resource->trabajo)->correo_corp
            ],
            'prestamo'=>[
                'idpers' => $this->resource->idpers,
                'iden_expe_trm' => $this->resource->iden_expe_trm,
                'iden_simu_sim'=> $this->resource->iden_simu_sim,
                'impo_cuot_sim'=> $this->resource->impo_cuot_sim,
                'anno'=> $this->resource->anno,
                'mes'=> $this->resource->mes,
                'plazo_total_mes'=> $this->resource->plazo_total_mes
            ]
        ];
    }
}