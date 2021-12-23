<?php

namespace App\Http\Controllers\Tramites\v1;

use App\Http\Controllers\Controller;
use App\Services\TramiteService;
use Illuminate\Http\Request;

class TramitesController extends Controller
{
    protected $tramiteService;

    public function __construct(TramiteService $tramiteService)
    {
        $this->tramiteService = $tramiteService;
    }
    public function getPorcentajeMisTramites(){

        return $this->showAll($this->tramiteService->porcentajeTramites(optional(auth()->user())->identifier));

    }
}
