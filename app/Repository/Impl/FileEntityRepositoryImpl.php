<?php

namespace App\Repository\Impl;
use App\Models\FileEntity;
use App\Repository\FileEntityRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;


class FileEntityRepositoryImpl implements FileEntityRepository
{
    protected $model;

    public function __construct(FileEntity $fileEntity)
    {
        $this->model = $fileEntity;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
         return $this->model->destroy($id);
    }

    public function find($id)
    {
        if (null == $user = $this->model->find($id)) {
            throw new ModelNotFoundException("Usuario no encontrado");
        }
        return $user;
    }

    public function getAll(): Collection
    {
        return $this->model->where('is_active',1)->get();
    }
}