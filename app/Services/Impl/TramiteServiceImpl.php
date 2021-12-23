<?php

namespace App\Services\Impl;

use App\Repository\MaeEntidaddetRepository;
use App\Repository\MaeProcesoRepository;
use App\Repository\TrmTramiteRepository;
use App\Services\TramiteService;


class TramiteServiceImpl implements TramiteService
{
    protected $trmTramiteRepository;
    protected $maeProcesoRepository;
    protected $maeEntidaddetRepository;
    public function __construct(TrmTramiteRepository $trmTramiteRepository,
                                MaeProcesoRepository $maeProcesoRepository,
                                MaeEntidaddetRepository $maeEntidaddetRepository)
    {
        $this->trmTramiteRepository = $trmTramiteRepository;
        $this->maeProcesoRepository = $maeProcesoRepository;
        $this->maeEntidaddetRepository = $maeEntidaddetRepository;
    }

    public function porcentajeTramites($persona_id)
    {
        $tramites =  $this->trmTramiteRepository->misTramites($persona_id);
        return $tramites->map(function ($tramite){
            return [
                'tramite' =>$tramite->iden_expe_trm,
                'nombre' =>$tramite->desc_asun_trm,
                'tipo_tramite' => optional($tipo = $this->maeEntidaddetRepository->getTipoTramite($tramite->tipo_tram_trm))->valo_cadu_det,
                'tipo_tramite_desc' => optional($tipo)->valo_cadd_det,
                'estado' =>(int) $tramite->flag_esta_trm,
                'proceso' => [
                               'proceso_id' =>$tramite->maeProceso->iden_proc_prc,
                               'process_name' => $tramite->maeProceso->nomb_proc_prc,
                               'subProcesos' => $subProcess = $this->maeProcesoRepository->subProcesos($tramite->maeProceso->iden_proc_prc)->map(function($sub) use ($tramite){
                                   return [
                                       'proceso'=>$sub,
                                       'nro_movimientos'=>$this->maeProcesoRepository->getMovimientos($tramite->iden_expe_trm,$sub->iden_proc_prc)->count()
                                   ];
                               }),
                    ],
                'completados'=> $completos = $subProcess->map((function($item){
                    return ['completo'=>$item['nro_movimientos'],'area'=>$item['proceso']['maeArea'],'orden'=>$item['proceso']['orde_secu_prc']];
                })),
                'nro_completados' => $tp= collect($completos)->where('completo','<>',0)->count(),
                'area_actual' => optional(collect($completos)->where('completo','<>',0)->last())['area']['desc_area_are'],
                'count_sub_process' => $tpr= $subProcess->count(),
                'percentage' => round(($tp/$tpr)*100 , 2)
            ];
        });


    }
}
