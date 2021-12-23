<?php

namespace App\Services\Impl;

use App\Repository\RecAporteRepository;
use App\Repository\UserRepository;
use App\Services\AporteService;
use App\Services\UserService;

class AporteServiceImpl implements AporteService
{
    protected $recAporteRepository;
    protected $userService;
    public function __construct(RecAporteRepository $recAporteRepository,
                                UserService $userService)
    {
        $this->recAporteRepository = $recAporteRepository;
        $this->userService = $userService;
    }

    public function getAporteAuthYear(array $user,$year)
    {
        $administrado = $this->userService->findSocio($user['cip'],$user['codofin'])->only('nomb_comp_per','codi_ccip_soc','codi_cdfi_soc','persona');
        $aporte = $this->recAporteRepository->getAporteAuthYear($user['identifier'],$year)->first();

        if($aporte){
            return [
                'aportante' =>
                    [
                        'cip'=>$administrado['codi_ccip_soc'],
                        'codofin'=>$administrado['codi_cdfi_soc'],
                        'nombre_completo' =>$administrado['persona']['nomb_comp_per'],
                        'dni' =>$administrado['persona']['nume_iden_per']
                    ],
                'tipo_aporte' => 'Titular 5%',
                'aportes' => ['anno' =>$aporte->anno,'total_aporte' =>number_format($aporte->total,2)]
            ];
        }
        return null;

    }

    public function getAporteAuthDetailYear(array $user,$year)
    {
        $administrado = $this->userService->findSocio($user['cip'],$user['codofin'])->only('nomb_comp_per','codi_ccip_soc','codi_cdfi_soc','persona');
        $aportes = $this->recAporteRepository->getAporteAuthDetailYear($user['identifier'],$year);

        if($aportes){
            return [
                'aportante' =>
                    [
                        'cip'=>$administrado['codi_ccip_soc'],
                        'codofin'=>$administrado['codi_cdfi_soc'],
                        'nombre_completo' =>$administrado['persona']['nomb_comp_per'],
                        'dni' =>$administrado['persona']['nume_iden_per']
                    ],
                'tipo_aporte' => 'Titular 5%',
                'aportes' => $aportes,
            ];
        }
        return null;
    }

    public function getAporteAuthAll(array $user)
    {
        $administrado = $this->userService->findSocio($user['cip'],$user['codofin'])->only('nomb_comp_per','codi_ccip_soc','codi_cdfi_soc','persona');
        $aportes = $this->recAporteRepository->getAporteAuthAll($user['identifier']);

        if($aportes){
            return [
                'aportante' =>
                    [
                        'cip'=>$administrado['codi_ccip_soc'],
                        'codofin'=>$administrado['codi_cdfi_soc'],
                        'nombre_completo' =>$administrado['persona']['nomb_comp_per'],
                        'dni' =>$administrado['persona']['nume_iden_per']
                    ],
                'tipo_aporte' => 'Titular 5%',
                'aportes' => $aportes->groupBy('anno')->values()->collapse()
            ];
        }
        return null;
    }
}
