<?php

namespace App\Repository\Digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SolicitudRepository
{
    public function getSoliciturdes($iden_pers_per):Collection;
    public function showSolicitud($id,$iden_pers_per):Model;
    public function showPath($id);
}