<?php

namespace App\Repository;

interface MaeEntidaddetRepository
{
    public function getConstantEntityForCode($code);
    public function getConstantEntityForCodeAndSequence($code,$secu);
    public function getGrados();
    public function getSituaciones();
    public function getEstadosCiviles();
    public function getEntidadPagos();
    public function getSexos();
    public function getParentescos();
    public function getGradoAgrupado($code_grado);
    public function getEscalaVigente();
    public function getTopeMaximo($vigencia_id,$grado_agrupado_id);
    public function getProducto();
    public function getPTypeDoc();
    public function getTipoTramite($id_secuencia);
    public function getTiposTramitesDig();


}
