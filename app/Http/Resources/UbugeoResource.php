<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UbugeoResource extends JsonResource
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
            'id' => strlen((string)$this->resource->iden_ubig_ubi)>5?(string)$this->resource->iden_ubig_ubi:"0".(string)$this->resource->iden_ubig_ubi,
            'name'=>$this->resource->nomb_ubig_ubi
        ];
    }
}
