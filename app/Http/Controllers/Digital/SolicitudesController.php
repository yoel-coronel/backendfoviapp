<?php

namespace App\Http\Controllers\Digital;

use App\Http\Controllers\Controller;
use App\Services\DigitalService;
use Illuminate\Http\Request;

class SolicitudesController extends Controller
{
    /**
     * @var DigitalService
     */
    private $digitalService;

    public function __construct(DigitalService $digitalService)
    {
        $this->digitalService = $digitalService;
    }

    public function getSolicitudes(){

        return $this->showAll($this->digitalService->getSoliciturdes(optional(auth()->user())->identifier));

    }
    public function show($id){

        return $this->showOne($this->digitalService->showSolicitud($id,optional(auth()->user())->identifier));

    }

    public function getPathFile($id){
        return response()->json(['data' => $this->digitalService->showPath($id)],200);
    }

}
