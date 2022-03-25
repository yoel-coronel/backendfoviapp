<?php

namespace App\Services\Impl;

use App\Repository\Digital\SolicitudRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

use App\Services\DigitalService;
use Illuminate\Support\Facades\Storage;

class DigitalServiceImpl implements DigitalService
{
    /**
     * @var SolicitudRepository
     */
    private $solicitudRepository;

    public function __construct(SolicitudRepository $solicitudRepository)
    {
        $this->solicitudRepository = $solicitudRepository;
    }

    public function getSoliciturdes($iden_pers_per): Collection
    {
        return $this->solicitudRepository->getSoliciturdes($iden_pers_per);
    }

    public function showSolicitud($id, $iden_pers_per): Model
    {
        return $this->solicitudRepository->showSolicitud($id, $iden_pers_per);
    }

    public function showPath($id)
    {
        $archivo = $this->solicitudRepository->showPath($id);

        if($archivo){
            return [
                'path_completo' =>Storage::disk("digFiles")->path($archivo->path),
                'path' => $archivo->path
            ];
        }
        return null;
    }
}