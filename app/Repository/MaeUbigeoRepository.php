<?php

namespace App\Repository;

interface MaeUbigeoRepository
{
    public function getDepartamentos();
    public function getProvincias($id);
    public function getDistritos($id);
    public function findUbigeo($dist_id);

}
