<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientosResource extends JsonResource
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
            'persona_id' => (int) $this->resource->idpers,
            'importe' => round($this->resource->importe,2),
            'moneda' => $this->resource->moneda,
            'entidad_pago' => $this->resource->entidadpago,
            'concepto' => $this->resource->concepto,
            'fecha' => Carbon::parse($this->resource->fechapago)->format("d/m/Y"),
        ];
    }
}
