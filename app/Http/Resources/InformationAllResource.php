<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InformationAllResource extends JsonResource
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
            'uuid'=> $this->resource->uuid,
            'title'=> $this->resource->title,
            'subtitle'=> $this->resource['sub-title'],
            'description'=> $this->resource->description,
            'url' => $this->resource->path?$this->resource->path:NULL,
            'enlace' => $this->resource->link,
            'fecha_puclic' => Carbon::parse($this->resource->created_at)->format("d/m/Y")
        ];

    }
}
