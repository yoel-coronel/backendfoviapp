<?php

namespace App\Repository\Impl;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepositoryImpl implements UserRepository
{
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
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
    public function findCip($cip)
    {
        if (null == $user = $this->model->where('cip',$cip)->first()) {
            return null;
        }
        return $user;
    }

    public function findEmail($email)
    {
        if (null == $user = ($this->model->where('email',$email)->get())->last()) {
            return null;
        }
        return $user;
    }

    public function findUserWithSocio($id)
    {
        return optional( $this->find($id) )->socio;
    }
}
