<?php

namespace App\Repository;


use Illuminate\Support\Collection;

interface NotificationEntityRepository extends BaseRepository
{
    public function misNotificaciones($personaId):Collection;

}