<?php

namespace App\Services\Impl;

use App\Repository\MaeEntidaddetRepository;
use App\Repository\MaeProcesoRepository;
use App\Repository\TrmTramiteRepository;
use App\Repository\VwAuraCreditoSocioRepository;
use App\Services\TramiteService;
use Illuminate\Support\Collection;


class TramiteServiceImpl implements TramiteService
{
    protected $trmTramiteRepository;
    protected $maeProcesoRepository;
    protected $maeEntidaddetRepository;
    /**
     * @var VwAuraCreditoSocioRepository
     */
    private $auraCreditoSocioRepository;

    public function __construct(TrmTramiteRepository $trmTramiteRepository,
                                MaeProcesoRepository $maeProcesoRepository,
                                MaeEntidaddetRepository $maeEntidaddetRepository,
                                VwAuraCreditoSocioRepository $auraCreditoSocioRepository)
    {
        $this->trmTramiteRepository = $trmTramiteRepository;
        $this->maeProcesoRepository = $maeProcesoRepository;
        $this->maeEntidaddetRepository = $maeEntidaddetRepository;
        $this->auraCreditoSocioRepository = $auraCreditoSocioRepository;
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
                'nro_completados' =>  (int)$tramite->flag_esta_trm == 2? $tp= $subProcess->count() : $tp= collect($completos)->where('completo','<>',0)->count(),
                'area_actual' => optional(collect($completos)->where('completo','<>',0)->last())['area']['desc_area_are'],
                'count_sub_process' =>  $tpr= $subProcess->count(),
                'percentage' => (int)$tramite->flag_esta_trm == 2? 100: round(($tp/$tpr)*100 , 2)
            ];
        });


    }

    public function findTramite($trmId)
    {
        $item = $this->auraCreditoSocioRepository->findTramite($trmId);

        if($item){
            return [
                'credito' => [
                    'dni'=>optional($item)['nrodni'],
                    'credito_id'=>optional($item)['iden_cred_crd'],
                    'persona_id'=>optional($item)['iden_pera_trm'],
                    'name_tramite'=>optional($item)['nomb_tram_trm'],
                    'expediente_id'=>optional($item)['iden_expe_trm'],
                    'expediente_id'=>optional($item)['iden_expe_trm'],
                    'impo_solitado'=>optional($item)['impo_soli_crd'],
                    'saldo_vencido'=>optional($item)['sald_venc_crd'],
                    'saldo_vencido'=>optional($item)['sald_venc_crd'],
                    'monto_cancelatorio'=>optional($item)['mont_canc'],
                    'monto_cancelatorio'=>optional($item)['mont_canc'],
                    'nucu_paga_crd'=>optional($item)['nucu_paga_crd'],
                    'nucu_venc_crd'=>optional($item)['nucu_venc_crd'],
                    'nucu_venc_crd'=>optional($item)['nucu_venc_crd'],
                    'name_producto'=>optional($item)['nomb_prod_prd'],
                    'moneda'=>optional($item)['moncrd'],
                    'estado'=>optional($item)['estcrd'],
                    'persona' =>[
                        'apellido_paterno' =>optional(optional($item)['persona'])['pel_pate_per,'],
                        'apellido_materno'=>optional(optional($item)['persona'])['apel_mate_per'],
                        'nombbres'=>optional(optional($item)['persona'])['nomb_pers_per'],
                        'nompres_copletos'=>optional(optional($item)['persona'])['nomb_comp_per']
                    ],
                    'socio' =>[
                        'codi_ccip_soc'=>optional(optional($item)['socio'])['codi_ccip_soc'],
                        'codi_cdfi_soc'=>optional(optional($item)['socio'])['codi_cdfi_soc'],
                        'codi_caja_soc'=>optional(optional($item)['socio'])['codi_caja_soc'],
                        'codi_mpol_soc'=>optional(optional($item)['socio'])['codi_mpol_soc'],
                    ]
                ]
            ];
        }
        return null;
    }

    public function getAdministradoCipOrDNI($doc)
    {
        return $this->trmTramiteRepository->getAdministradoCipOrDNI($doc);
    }

    public function getTramites($itenpers)
    {
        return $this->trmTramiteRepository->getTramites($itenpers);
    }
    public function findPersonaPorTramiteId($trmId)
    {
        return $this->auraCreditoSocioRepository->findPersonaPorTramiteId($trmId);
    }
}
