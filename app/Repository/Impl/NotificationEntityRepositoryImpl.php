<?php

namespace App\Repository\Impl;

use App\Models\NotificationEntity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class NotificationEntityRepositoryImpl implements \App\Repository\NotificationEntityRepository
{
    protected $model;

    public function __construct(NotificationEntity $notificationEntity)
    {
        $this->model = $notificationEntity;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        $data = $this->model->create($data);
        return $this->find($data->id);
    }

    public function update(array $data, $id)
    {
        $this->model->where('id', $id)
            ->update($data);
        return $this->find($id);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        if (null == $data = $this->model->find($id)) {
            throw new ModelNotFoundException("recurso no encontrado");
        }
        return $data;
    }

    public function misNotificaciones($personaId): Collection
    {
        return $this->model->where('is_active',1)
                            ->where('identifier',$personaId)
                            ->whereNull('read_at')
                            ->get();
    }
    public function misAllNotificaciones($personaId): Collection
    {
        return $this->model->where('is_active',1)
            ->where('identifier',$personaId)
            ->take(15)->get();
    }
}