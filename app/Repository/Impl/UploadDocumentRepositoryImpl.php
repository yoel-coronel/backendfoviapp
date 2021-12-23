<?php

namespace App\Repository\Impl;
use App\Models\UploadDocument;
use App\Repository\UploadDocumentRepository;

class UploadDocumentRepositoryImpl implements UploadDocumentRepository
{
    protected $model;

    public function __construct(UploadDocument $uploadDocument)
    {
        $this->model = $uploadDocument;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function getDocumentsAuth(array $user)
    {
        return $this->model->where('identifier',$user['identifier'])->where('is_active','<>',0)->where('status','<>',UploadDocument::STATUS_MESA_PARTES)->get();
    }
    public function findDocumentsAuth(array $user,$id)
    {
        return $this->model->where('identifier',$user['identifier'])->where('id',$id)->where('is_active','<>',0)->first();
    }
}