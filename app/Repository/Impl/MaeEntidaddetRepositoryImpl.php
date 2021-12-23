<?php

namespace App\Repository\Impl;

use App\Models\Oracle\MaeEntidaddet;
use App\Repository\MaeEntidaddetRepository;

class MaeEntidaddetRepositoryImpl implements MaeEntidaddetRepository
{
    protected $model;

    /**
     * MaeEntidaddetRepository constructor.
     *
     * @param MaeEntidaddet $entidaddet
     */
    public function __construct(MaeEntidaddet $entidaddet)
    {
        $this->model = $entidaddet;
    }
    public function getConstantEntityForCode($code)
    {
        return $this->model->where('codi_enti_ent',$code)
            ->where('flag_esta_det','<>',0)
            ->orderBy('secu_enti_det','asc')
            ->get();
    }

    public function getConstantEntityForCodeAndSequence($code, $secu)
    {
        return $this->model->where('codi_enti_ent',$code)
                                ->where('secu_enti_det',$secu)
                                ->where('flag_esta_det','<>',0)
                                ->orderBy('secu_enti_det','asc')
                                ->get();
    }

    public function getGrados()
    {
        return $this->model->where('codi_enti_ent','CODIGRADSOC')
            ->where('flag_esta_det',1)
            ->whereNotNull('valo_dect_det')
            ->select('secu_enti_det','valo_cadu_det')
            ->OrderBy('secu_enti_det','asc')
            ->get();
    }

    public function getSituaciones()
    {
        return $this->model->where('codi_enti_ent','CODISITUSOC')
            ->where('flag_esta_det',1)
            ->whereNotNull('valo_numu_det')
            ->select('secu_enti_det','valo_cadu_det')
            ->OrderBy('valo_numu_det','asc')
            ->get();
    }

    public function getEstadosCiviles()
    {
        return $this->model->where('codi_enti_ent','ESTACIVIPER')
            ->where('flag_esta_det',1)
            ->select('secu_enti_det','valo_cadu_det')
            ->OrderBy('secu_enti_det','asc')
            ->get();
    }

    public function getEntidadPagos()
    {
        return $this->model->where('codi_enti_ent','ENTIPAGOSOC')
            ->where('flag_esta_det',1)
            ->select('secu_enti_det','valo_cadu_det')
            ->OrderBy('secu_enti_det','asc')
            ->get();
    }

    public function getSexos()
    {
        return $this->model->where('codi_enti_ent','SEXOPERSPER')
            ->where('flag_esta_det',1)
            ->select('secu_enti_det','valo_cadu_det')
            ->OrderBy('secu_enti_det','asc')
            ->get();
    }

    public function getParentescos()
    {
        return $this->model->where('codi_enti_ent','GRADPAREPER')
            ->where('flag_esta_det',1)
            ->select('secu_enti_det','valo_cadu_det')
            ->OrderBy('secu_enti_det','asc')
            ->get();
    }

    public function getGradoAgrupado($code_grado)
    {
         return $this->model->where('codi_enti_ent','CODIGRADSOC')
             ->where('flag_esta_det','<>',0)
             ->where('secu_enti_det',$code_grado)
             ->select('valo_numd_det')
             ->first();
    }

    public function getEscalaVigente()
    {
        return $this->model->where('codi_enti_ent','ESCACALICRD')
            ->where('flag_esta_det','<>',0)
            ->where('valo_cadd_det','VIG')
            ->select('secu_enti_det')
            ->first();
    }

    public function getTopeMaximo($vigencia_id, $grado_agrupado_id)
    {
        return $this->model->where('codi_enti_ent','ESCAGRADCON')
            ->where('flag_esta_det','<>',0)
            ->where('valo_numu_det',$vigencia_id)
            ->where('secu_enti_det',$grado_agrupado_id)
            ->first();
    }

    public function getProducto()
    {
        return $this->model->where('codi_enti_ent','CODPROSIM')
            ->where('flag_esta_det','<>',0)
            ->where('valo_numu_det',145)
            ->where('secu_enti_det',1)
            ->first();
    }

    public function getPTypeDoc()
    {
        return $this->model->where('codi_enti_ent','FORMATODOCU')
            ->where('flag_esta_det','<>',0)
            ->get();
    }
    public function getTipoTramite($id_secuencia)
    {
        return $this->model->where('codi_enti_ent','TIPOTRAMTRM')
            ->where('flag_esta_det','<>',0)
            ->where('secu_enti_det',$id_secuencia)
            ->first();
    }

    public function getTiposTramitesDig()
    {
        return $this->model->where('codi_enti_ent','TIPOTRMDIGI')
            ->where('flag_esta_det','<>',0)
            ->orderBy('secu_enti_det','asc')
            ->get();
    }


}
