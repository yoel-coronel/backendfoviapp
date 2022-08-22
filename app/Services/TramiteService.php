<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface TramiteService
{
    public function porcentajeTramites($persona_id);
    public function findTramite($trmId);
    public function getAdministradoCipOrDNI($doc);
    public function getTramites($itenpers);
    public function findPersonaPorTramiteId($trmId);

}
