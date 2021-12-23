<?php

namespace App\Http\Resources;

use App\Services\Impl\UploadServiceImpl;
use App\Services\UploadService;
use Illuminate\Http\Resources\Json\JsonResource;

class fileEntityResource extends JsonResource
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
            'file' => $this->resource->path,
            'title' => $this->resource->title,
            'description' =>$this->resource->description
        ];
    }
}
