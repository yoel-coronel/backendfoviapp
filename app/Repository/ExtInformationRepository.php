<?php

namespace App\Repository;

use Illuminate\Http\Request;

interface ExtInformationRepository extends BaseRepository
{
    public function storeAndUpdate(Request $request, array $user);
    public function getBeneficiarios(array $user);
    public function findIdenPersPerAndCip($idenpersper,$cip);
    public function findNroDNIAndCip($dni,$cip);
}
