<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface FileEntityService
{
    public function store(array $data);
    public function getAll():Collection;
}