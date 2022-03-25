<?php

namespace App\Repository\Digital\Impl;

use App\Models\Digital\Archivo;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

use App\Repository\Digital\SolicitudRepository;


class SolicitudRepositoryImpl implements SolicitudRepository
{

    public function getSoliciturdes($iden_pers_per): Collection
    {
        return Solicitud::with(['archivos','tipoSolicitud','maeSocio','userCreaSolicitud','areaCrea','areaRecibe','notifications'])
            ->where('iden_pers_per',$iden_pers_per)
            ->where('condicion','=',Solicitud::CONDICION_ENVIADO)
            ->orderByDesc('id')->get();
    }

    public function showSolicitud($id, $iden_pers_per): Model
    {
        return Solicitud::with(['archivos','tipoSolicitud','maeSocio','userCreaSolicitud','areaCrea','areaRecibe','notifications'])
            ->where('iden_pers_per',$iden_pers_per)
            ->where('condicion','=',Solicitud::CONDICION_ENVIADO)
            ->where('id',$id)
            ->orderByDesc('id')->first();
    }

    public function showPath($id)
    {
        return  Archivo::find($id);
    }
}