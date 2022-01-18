<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface NotificationEntityService
{
    public function guestStore(array $data);
    public function guestUpdate(array $data, $id);
    public function misNotificaciones($personaId):Collection;
    public function misAllNotificaciones($personaId):Collection;
}