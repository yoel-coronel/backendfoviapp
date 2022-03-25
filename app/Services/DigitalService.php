<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface DigitalService
{

    public function getSoliciturdes($iden_pers_per):Collection;
    public function showSolicitud($id,$iden_pers_per):Model;
    public function showPath($id);

}