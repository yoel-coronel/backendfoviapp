<?php

namespace App\Http\Controllers\Notificaicones\auth\v1;

use App\Http\Controllers\Controller;
use App\Services\NotificationEntityService;
use App\Services\UploadService;
use Illuminate\Http\Request;

class NotificationAuthController extends Controller
{
    protected $notificationEntityService;
    protected $uploadService;

    public function __construct(NotificationEntityService $notificationEntityService, UploadService $uploadService)
    {
        $this->notificationEntityService = $notificationEntityService;
        $this->uploadService = $uploadService;
    }
    public function getMisNotificaiones(){
        $personaId = optional(auth()->user())->identifier;
        return $this->notificationEntityService->misNotificaciones($personaId)->map(function ($item){
            return [
                "id" => $item->id,
                "title"=> $item->title,
                "description"=> $item->description,
                'file' => $item->path?$this->uploadService->loadDocument($item->path):null,
                "url"=> $item->url,
                "identifier"=> (int)$item->identifier,
                "read_at"=> $item->read_at,
            ];
        });
    }
    public function readAuth($id){
        $data = ['read_at'=>now()];
        try {
            $this->notificationEntityService->guestUpdate($data,$id);
            return $this->successResponseStatus("Leído con éxito.");

        }catch (\Exception $exception){
            return $this->errorResponse("Error en leer la información.",1,400);
        }



    }
}
