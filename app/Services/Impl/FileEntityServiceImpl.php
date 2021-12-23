<?php

namespace App\Services\Impl;

use App\Repository\FileEntityRepository;
use App\Services\FileEntityService;
use Illuminate\Support\Collection;

class FileEntityServiceImpl implements FileEntityService
{
    protected $fileEntityRepository;

    public function __construct(FileEntityRepository $fileEntityRepository)
    {
        $this->fileEntityRepository = $fileEntityRepository;
    }


    public function store(array $data)
    {

        return $this->fileEntityRepository->create($data);

    }

    public function getAll(): Collection
    {
        return $this->fileEntityRepository->getAll();
    }
}