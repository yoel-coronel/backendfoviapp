<?php

namespace App\Repository\Impl;

use App\Models\HelpQuestion;
use App\Repository\HelpQuestionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HelpQuestionRepositoryImpl implements HelpQuestionRepository
{
    protected $model;

    public function __construct(HelpQuestion $helpQuestion)
    {
        $this->model = $helpQuestion;
    }

    public function all()
    {
       return $this->model->where('is_active',1)->orderBy('order','asc')->get();
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
        if (null == $data = $this->model->find($id)) {
            throw new ModelNotFoundException("recurso no encontrado");
        }
        return $data;
    }
}