<?php

namespace App\Repository\Impl;
use App\Models\Oracle\MaeArea;
use App\Repository\MaeAreaRepository;
use Illuminate\Support\Collection;

class MaeAreaRepositoryImpl implements MaeAreaRepository
{
    /**
     * @var MaeAreaRepository
     */
    private $maeArea;

    public function __construct(MaeArea $maeArea)
    {
        $this->maeArea = $maeArea;
    }

    public function getAreas():Collection
    {
        return $this->maeArea->select('iden_area_are','desc_area_are')->where('flag_esta_are','<>',0)->get();
    }
}