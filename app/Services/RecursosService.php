<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface RecursosService
{
    public function getConstantEntityForCode($code);
    public function getConstantEntityForCodeAndSequence($code,$secu);
    public function getGrados();
    public function getSituaciones();
    public function getEstadosCiviles();
    public function getEntidadPagos();
    public function getSexos();
    public function getParentescos();
    public function getDepartamentos();
    public function getProvincias($id);
    public function getDistritos($id);
    public function getPTypeDoc();
    public function getTiposTramitesDig();
    public function getEmpresas():Collection;
    public function getAreas():Collection;
}
