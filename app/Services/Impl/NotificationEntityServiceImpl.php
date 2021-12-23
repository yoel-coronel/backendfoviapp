<?php

namespace App\Services\Impl;

use App\Repository\NotificationEntityRepository;
use Illuminate\Support\Collection;
use App\Services\NotificationEntityService;

class NotificationEntityServiceImpl implements NotificationEntityService
{
    protected $notificationEntityRepository;

    public function __construct(NotificationEntityRepository $notificationEntityRepository)
    {
        $this->notificationEntityRepository = $notificationEntityRepository;
    }

    public function guestStore(array $data)
    {
        return $this->notificationEntityRepository->create($data);
    }

    public function guestUpdate(array $data, $id)
    {
        return $this->notificationEntityRepository->update($data,$id);
    }

    public function misNotificaciones($personaId): Collection
    {
        return $this->notificationEntityRepository->misNotificaciones($personaId);
    }
}