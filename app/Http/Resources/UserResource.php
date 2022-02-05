<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'=>$this->resource->name,
            'last_name'=>$this->resource->last_name,
            'email'=>$this->resource->email,
            'cip'=>$this->resource->cip,
            'telefono'=>$this->resource->telephone,
            'identifier'=>$this->resource->identifier,
            'edad' => $this->resource->age(Carbon::parse(($this->resource->person->fech_naci_per))),
            'grado' =>$this->resource->grado($this->resource->socio->codi_grad_soc),
            'dni' =>$this->resource->person->nume_iden_per,
            'is_notification' => $this->resource->is_notificacion($this->resource->identifier),
            'count_notification' => $this->resource->countNoti($this->resource->identifier),
        ];
    }
}
