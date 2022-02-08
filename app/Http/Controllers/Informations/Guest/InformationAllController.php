<?php

namespace App\Http\Controllers\Informations\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\InformationAllCollection;
use App\Services\InformationAllService;
use App\Services\UploadService;
use Illuminate\Http\Request;

class InformationAllController extends Controller
{
    /**
     * @var InformationAllService
     */
    private $informationAllService;
    /**
     * @var UploadService
     */
    private $uploadService;

    public function __construct(InformationAllService $informationAllService,UploadService $uploadService)
    {
        $this->informationAllService = $informationAllService;
        $this->uploadService = $uploadService;
    }

    public function index(){

        return $this->showAll(collect(InformationAllCollection::make($this->informationAllService->all()))->map(function ($item){
            return [
                'uuid'=> $item['uuid'],
                'title'=> $item['title'],
                'subtitle'=> $item['subtitle'],
                'description'=> $item['description'],
                'url' => $item['url']?$this->uploadService->loadDocument($item['url']):null,
                'tipo' => $item['url']?"imagen":null,
                'enlace' => $item['enlace'],
                'fecha_puclic' => $item['fecha_puclic']
            ];
        }));

    }

}
