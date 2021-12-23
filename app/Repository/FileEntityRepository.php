<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface FileEntityRepository extends BaseRepository
{
    public function getAll():Collection;
}