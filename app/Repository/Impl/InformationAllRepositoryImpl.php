<?php

namespace App\Repository\Impl;
use App\Models\InformationAll;
use App\Repository\InformationAllRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InformationAllRepositoryImpl implements InformationAllRepository
{
    /**
     * @var InformationAll
     */
    private $model;

    public function __construct(InformationAll $informationAll)
    {
        $this->model = $informationAll;
    }


    public function all()
    {
        return $this->model->where('status',1)->get();
    }

    public function create(array $data)
    {
        $this->model->create($data);
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
}