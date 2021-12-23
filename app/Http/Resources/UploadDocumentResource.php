<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class UploadDocumentResource extends JsonResource
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
            'uuid' =>$this->resource->uuid,
            'cip'  =>$this->resource->cip,
            'description'  =>$this->resource->description,
            'reason'  =>$this->resource->reason,
            'status'  =>$this->resource->status,
            'document_viewer' => route('uploads-document',$this->resource->getRouteKey())
        ];
    }
}
