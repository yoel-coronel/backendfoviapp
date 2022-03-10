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
            'pop_up_enabled' => true,
            'additional_options' =>[
               // 'redirection' =>'https://docs.google.com/forms/d/e/1FAIpQLSc_wroKxuX1-Ou-367hk7vn9OT-SlsOsGAk2UjyMeIggFXeeg/viewform?usp=sf_link',
                'title' => 'Asesoria Virtual',
                'sub_title' =>'FOVIPOL '. now()->format('Y'),
                'images' => [
                    ['url'=>'http://www.fovipol.gob.pe/wp-content/uploads/2022/02/POP-UP-1-4.png', 'redirection' =>'https://docs.google.com/forms/d/e/1FAIpQLSc_wroKxuX1-Ou-367hk7vn9OT-SlsOsGAk2UjyMeIggFXeeg/viewform?usp=sf_link',],
                    ['url'=>'http://www.fovipol.gob.pe/wp-content/uploads/2022/02/pop-up-2-3.png', 'redirection' =>'https://docs.google.com/forms/d/e/1FAIpQLSc_wroKxuX1-Ou-367hk7vn9OT-SlsOsGAk2UjyMeIggFXeeg/viewform?usp=sf_link',],
                ]
            ]
        ];
    }
}
