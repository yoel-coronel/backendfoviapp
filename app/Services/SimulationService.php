<?php

namespace App\Services;

interface SimulationService
{
    public function getAllSimulationUserAuth(array $user);
    public function capacidadMaxSimulation($id);
    public function simularPrestamo(array $data);

}
