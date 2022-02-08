<?php

namespace App\Services\Impl;

use App\Repository\InformationAllRepository;
use App\Services\InformationAllService;
use App\Services\UploadService;

class InformationAllServiceImpl implements InformationAllService
{
    /**
     * @var InformationAllRepository
     */
    private $informationAllRepository;

    public function __construct(InformationAllRepository $informationAllRepository)
    {
        $this->informationAllRepository = $informationAllRepository;

    }

    public function all()
    {
        return $this->informationAllRepository->all();
    }

    public function create(array $data)
    {
        return $this->informationAllRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->informationAllRepository->update($data,$id);
    }

    public function delete($id)
    {
        return $this->informationAllRepository->delete($id);
    }

    public function find($id)
    {
        return $this->informationAllRepository->find($id);
    }
}