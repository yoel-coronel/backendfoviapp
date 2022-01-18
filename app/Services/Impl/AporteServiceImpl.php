<?php

namespace App\Services\Impl;

use App\Repository\RecAporteRepository;
use App\Repository\UserRepository;
use App\Services\AporteService;
use App\Services\UserService;
use Illuminate\Support\Collection;

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
        $nivelacion = $this->recAporteRepository->getNivelacionAuthYear($user['identifier'],$year)->first();

            return [
                'aportante' =>
                    [
                        'cip'=>$administrado['codi_ccip_soc'],
                        'codofin'=>$administrado['codi_cdfi_soc'],
                        'nombre_completo' =>$administrado['persona']['nomb_comp_per'],
                        'dni' =>$administrado['persona']['nume_iden_per']
                    ],
                "aportes" =>[
                    'tipo_aporte' => 'Titular 5%',
                    'aportes' => ['anno' =>optional($aporte)->anno?:$year,'total_aporte' =>number_format(optional($aporte)->total,2)]
                ],
                "nivelacion" =>[
                    'tipo_aporte' => 'Nivelación',
                    'nivelaciones' => ['anno' =>optional($aporte)->anno?:$year,'total_nivelacion' =>number_format(optional($nivelacion)->total,2)]
                ],

            ];
    }

    public function getAporteAuthDetailYear(array $user,$year)
    {
        $administrado = $this->userService->findSocio($user['cip'],$user['codofin'])->only('nomb_comp_per','codi_ccip_soc','codi_cdfi_soc','persona');
        $aportes = $this->recAporteRepository->getAporteAuthDetailYear($user['identifier'],$year);
        $nivelaciones = $this->recAporteRepository->getNivelacionAuthDetailYear($user['identifier'],$year);

        if($aportes){
            return [
                'aportante' =>
                    [
                        'cip'=>$administrado['codi_ccip_soc'],
                        'codofin'=>$administrado['codi_cdfi_soc'],
                        'nombre_completo' =>$administrado['persona']['nomb_comp_per'],
                        'dni' =>$administrado['persona']['nume_iden_per']
                    ],
                "aportes"=>[
                    'tipo_aporte' => 'Titular 5%',
                    'aportes' => $aportes,
                ],
                "nivelaciones" =>[
                    'tipo_aporte' => 'Nivelación',
                    'nivelaciones' => $nivelaciones,
                ],

            ];
        }
        return null;
    }

    public function getAporteAuthAll(array $user)
    {
        $administrado = $this->userService->findSocio($user['cip'],$user['codofin'])->only('nomb_comp_per','codi_ccip_soc','codi_cdfi_soc','persona');
        $aportes = $this->recAporteRepository->getAporteAuthAll($user['identifier']);
        $nivelaciones = $this->recAporteRepository->getNivelacionAuthAll($user['identifier']);

        if($aportes){
            return [
                'aportante' =>
                    [
                        'cip'=>$administrado['codi_ccip_soc'],
                        'codofin'=>$administrado['codi_cdfi_soc'],
                        'nombre_completo' =>$administrado['persona']['nomb_comp_per'],
                        'dni' =>$administrado['persona']['nume_iden_per']
                    ],
                "aportes" =>[
                    'tipo_aporte' => 'Titular 5%',
                    'aportes' => $aportes->groupBy('anno')->map(function ($item){
                        return [
                            "aporte"=>collect($this->autoCompletarMeses($item->values()))->values(),
                            "total" =>round($item->sum('total'),2)];
                    })->values(),
                    'gran_total'=>round(collect($aportes->groupBy('anno')->values()->collapse())->sum('total'),2)
                ],
                "nivelaciones" =>[
                    'tipo_aporte' => 'Nivelación',
                    'nivelaciones' => $nivelaciones->groupBy('anno')->map(function ($item){
                        return [
                            "nivelacion"=>collect($this->autoCompletarMeses($item->values()))->values(),
                            "total" =>round($item->sum('total'),2)];
                    })->values(),
                    'gran_total'=>round(collect($nivelaciones->groupBy('anno')->values()->collapse())->sum('total'),2)
                ],

            ];
        }
        return null;
    }
    protected function autoCompletarMeses(Collection $collection){
        $tamannoArrayData = $collection->first();
        $arrayFormat = $collection;
        foreach ($this->getMeses() as $key){
           $filter = $collection->where('mes',$key)->first();
           if ($filter){
           }else{
               $arrayFormat->push(
                   [
                       'anno'=>$tamannoArrayData->anno,
                       'mes'=>$key,
                       'total'=>"0.00",
                   ]
               );
           }
        }
        return $arrayFormat->sortBy('mes')->toArray();
    }
    protected function getMeses(){
        return ["01","02","03","04","05","06","07","08","09","10","11","12"];
    }
}
