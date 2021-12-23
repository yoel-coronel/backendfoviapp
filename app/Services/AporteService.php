<?php

namespace App\Services;

interface AporteService
{
    public function getAporteAuthYear(array $user,$year);
    public function getAporteAuthDetailYear(array $user,$year);
    public function getAporteAuthAll(array $user);
}
