<?php

namespace App\Repository;

interface RecAporteRepository
{
    public function getAporteAuthYear($persona_id,$year);
    public function getAporteAuthDetailYear($persona_id,$year);
    public function getAporteAuthAll($persona_id);
    public function getNivelacionAuthYear($persona_id,$year);
    public function getNivelacionAuthDetailYear($persona_id,$year);
    public function getNivelacionAuthAll($persona_id);
}
