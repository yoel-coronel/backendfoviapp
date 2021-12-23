<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface TrmTramiteRepository extends BaseRepository
{

    public function misTramites($persona_id):Collection;

}
