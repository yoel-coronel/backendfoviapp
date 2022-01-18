<?php

namespace App\Repository\Impl;

use App\Models\Oracle\ExtInformacion;
use App\Models\Oracle\MaePersona;
use App\Models\User;
use App\Repository\ExtInformationRepository;
use App\Repository\MaeUbigeoRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExtInformationRepositoryImpl implements ExtInformationRepository
{
    protected $model;

    protected $ubigeo;
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(ExtInformacion $extInformacion, MaeUbigeoRepository $maeUbigeoRepository)
    {
        $this->model = $extInformacion;
        $this->ubigeo = $maeUbigeoRepository;
    }

    public function all()
    {
        // TODO: Implement all() method.
    }
    public function create(array $data)
    {
        $extInfo = new  ExtInformacion();
        $extInfo->iden_exte_inf=$this->model::generateKey();
        $extInfo->iden_pers_per=$data['iden_pers_per'];
        $extInfo->nume_iden_per=$data['nroIdentidad'];
        $extInfo->apel_pate_per=$data['apelPat'];
        $extInfo->apel_mate_per=$data['apelMat'];
        $extInfo->nomb_pers_per=$data['nombComp'];
        $extInfo->nomb_comp_per=$data['apelPat'] .' '.$data['apelMat'].' '.$data['nombComp'];
        $extInfo->esta_civi_per=$data['estacivil'];
        $extInfo->corr_prin_per=$data['email'];
        $extInfo->corr_secu_per=$data['email'];
        $extInfo->celu_prin_per=$data['celular'];
        $extInfo->celu_secu_per=$data['celular'];
        $extInfo->tlfn_prin_per=$data['telfijo'];
        $extInfo->tlfn_secu_per=$data['telfijo'];
        $extInfo->ubig_domi_per=$data['nroDis'];
        $extInfo->dire_domi_per=$data['datoDom'];
        $extInfo->refe_domi_per=NULL;
        $extInfo->codi_ccip_soc=$data['cip'];
        $extInfo->codi_cdfi_soc=$data['codofin'];
        $extInfo->codi_caja_soc=NULL;
        $extInfo->camp_tipo_inf=5;
        $extInfo->fech_crea_aud=now();
        $extInfo->usua_crea_aud='MIFOVIPOL';
        $extInfo->flag_exte_inf=1;
        $extInfo->iden_extp_inf=null;
        $extInfo->esci_desc_per=NULL;
        $extInfo->fech_naci_per=$data['fecNac'];
        $extInfo->flag_disc_inf=NULL;
        $extInfo->nume_cona_inf=NULL;
        $extInfo->iden_extp_inf=isset($data['iden_extp_inf'])?$data['iden_extp_inf']:null;
        $extInfo->codi_grad_soc=$data['grado'];
        $extInfo->codi_situ_soc=$data['situacion'];
        $extInfo->fech_baja_soc=$data['fecRet'];
        $extInfo->sexo_pers_per=$data['sexo'];
        $extInfo->grad_pare_per=$data['parentesco'];
        $extInfo->fech_iesc_soc=$data['fecIngr'];
        $extInfo->save();

        return $extInfo;
    }

    public function update(array $data, $id)
    {
        $extInfo = $this->model->where('iden_exte_inf', $id)->first();
        $extInfo->iden_pers_per=$data['iden_pers_per'];
        $extInfo->nume_iden_per=$data['nroIdentidad'];
        $extInfo->apel_pate_per=$data['apelPat'];
        $extInfo->apel_mate_per=$data['apelMat'];
        $extInfo->nomb_pers_per=$data['nombComp'];
        $extInfo->nomb_comp_per=$data['apelPat'] .' '.$data['apelMat'].' '.$data['nombComp'];
        $extInfo->esta_civi_per=$data['estacivil'];
        $extInfo->corr_prin_per=$data['email'];
        $extInfo->corr_secu_per=$data['email'];
        $extInfo->celu_prin_per=$data['celular'];
        $extInfo->celu_secu_per=$data['celular'];
        $extInfo->tlfn_prin_per=$data['telfijo'];
        $extInfo->tlfn_secu_per=$data['telfijo'];
        $extInfo->ubig_domi_per=$data['nroDis'];
        $extInfo->dire_domi_per=$data['datoDom'];
        $extInfo->refe_domi_per=NULL;
        $extInfo->codi_ccip_soc=$data['cip'];
        $extInfo->codi_cdfi_soc=$data['codofin'];
        $extInfo->codi_caja_soc=NULL;
        $extInfo->camp_tipo_inf=5;
        $extInfo->fech_crea_aud=now();
        $extInfo->usua_crea_aud='MIFOVIPOL';
        $extInfo->flag_exte_inf=1;
        $extInfo->iden_extp_inf=isset($data['iden_extp_inf'])?$data['iden_extp_inf']:null;
        $extInfo->esci_desc_per=NULL;
        $extInfo->fech_naci_per=$data['fecNac'];
        $extInfo->flag_disc_inf=NULL;
        $extInfo->nume_cona_inf=NULL;
        $extInfo->iden_expe_trm=NULL;
        $extInfo->codi_grad_soc=$data['grado'];
        $extInfo->codi_situ_soc=$data['situacion'];
        $extInfo->fech_baja_soc=$data['fecRet'];
        $extInfo->sexo_pers_per=$data['sexo'];
        $extInfo->grad_pare_per=$data['parentesco'];
        $extInfo->fech_iesc_soc=$data['fecIngr'];
        $extInfo->save();
        return $extInfo;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function find($id)
    {
        if (null == $recurson = $this->model->where('iden_exte_inf',$id)->first()) {
            throw new ModelNotFoundException("Recurso no encontrado");
        }
        return $recurson;
    }

    public function storeAndUpdate(Request $request,array $user)
    {
        $data = $request->all();
        $extInformacion = $this->findIdenPersPerAndCip($user['identifier'],$user['cip']);

        $data['iden_pers_per'] = $user['identifier'];
        $data['cip'] = $user['cip'];
        $data['codofin'] = $user['codofin'];

        if ($extInformacion){
            $data['iden_exte_inf'] = $extInformacion->iden_exte_inf;
            $extInformacion = $this->update($data,$extInformacion->iden_exte_inf);
        }else{
            $extInformacion = $this->create($data);
        }

        $datos = collect($request->beneficiarios);

        if ($datos->count()>0 && $extInformacion){

            foreach ($datos as $kay=>$detalle){

                $detalle['iden_extp_inf'] = $extInformacion['iden_exte_inf'];

                $extInformacion1 = $this->findNroDNIAndCip($detalle['nroIdentidad'],$user['cip']);

                $detalle['iden_pers_per']=null;
                $detalle['cip'] = $user['cip'];
                $detalle['codofin'] = $user['codofin'];

                if ($extInformacion1){
                    $this->update($detalle,(int)$extInformacion1['iden_exte_inf']);
                }else{
                    $this->create($detalle);
                }

            }

        }

        $usr = User::find($user['id']);
        $usr->is_active=1;
        $usr->save();

        return $this->getBeneficiarios(optional(auth()->user())->toArray());

    }
    public function getBeneficiarios(array $user)
    {
        $extInformacions_form = new Collection();
        $beneficiarios = new Collection();
        $extInformacion = optional($this->model->where('iden_pers_per',$user['identifier'])->where('codi_ccip_soc',$user['cip'])->where('flag_exte_inf','<>',0)->first())->toArray();

        if($extInformacion){
            $extInformacions_form->put('administrado', $this->getAdministrado($extInformacion));
        }else{
            $administrado = optional(MaePersona::with('socio')->where('iden_pers_per',$user['identifier'])->first())->toArray();
            $extInformacion = optional($this->create($this->getFormateaDataAdministrado($administrado,$user)))->toArray();
            $extInformacions_form->put('administrado', $this->getAdministrado($extInformacion));
        }

        $extInformacions = $this->model->where('iden_extp_inf',$extInformacion['iden_exte_inf'])->where('codi_ccip_soc',$user['cip'])->where('flag_exte_inf','<>',0)->get();

        if ($extInformacions->count()>0){
            foreach ($extInformacions as $key=>$item) {
                $beneficiarios->push($this->getAdministrado($item->toArray()));
            }
        }
        return $extInformacions_form->put('beneficiarios',$beneficiarios);
    }

    protected function getAdministrado(array $data){
        $ubigeo = $this->ubigeo->findUbigeo($data['ubig_domi_per']);

            return [
                'id' => (int) $data['iden_exte_inf'],
                'nroIdentidad' => $data['nume_iden_per'],
                'apelPat' => $data['apel_pate_per'],
                'apelMat' => $data['apel_mate_per'],
                'nombComp' => $data['nomb_pers_per'],
                'estacivil' => (int) $data['esta_civi_per'],
                'email' => $data['corr_prin_per'],
                'celular' => $data['celu_prin_per'],
                'telfijo' => $data['tlfn_prin_per'],
                'nroDpt' => $ubigeo['depa_id'],
                'nroProv' => $ubigeo['prov_id'],
                'nroDis' => $data['ubig_domi_per'],
                'datoDom' => $data['dire_domi_per'],
                'fecNac' => isset($data['fech_naci_per'])?Carbon::parse($data['fech_naci_per'])->format('Y-m-d'):null,
                'grado' => (int) $data['codi_grad_soc'],
                'situacion' => (int) $data['codi_situ_soc'],
                'fecRet' => isset($data['fech_baja_soc'])?Carbon::parse($data['fech_baja_soc'])->format('Y-m-d'):null,
                'fecIngr' => isset($data['fech_iesc_soc'])?Carbon::parse($data['fech_iesc_soc'])->format('Y-m-d'):null,
                'sexo' => (int) $data['sexo_pers_per'],
                'parentesco' => (int) $data['grad_pare_per']
            ];
    }
    protected function getFormateaDataAdministrado(array $data,array $user){
            return [
                'nroIdentidad' => $data['nume_iden_per'],
                'apelPat' => $data['apel_pate_per'],
                'apelMat' => $data['apel_mate_per'],
                'nombComp' => $data['nomb_pers_per'],
                'estacivil' => $data['esta_civi_per'],
                'email' => $user['email'],
                'cip' => $user['cip'],
                'codofin' => $user['codofin'],
                'celular' => $user['telephone'],
                'telfijo' => $data['nume_telc_per'],
                'iden_pers_per' => $user['identifier'],
                'nroDpt' => null,
                'nroProv' => null,
                'nroDis' => $data['ubig_resi_per'],
                'datoDom' => $data['dire_pers_per'],
                'fecNac' => isset($data['fech_naci_per'])?Carbon::parse($data['fech_naci_per'])->format('Y-m-d'):null,
                'grado' => $data['socio']['codi_grad_soc'],
                'situacion' => $data['socio']['codi_situ_soc'],
                'fecRet' => isset($data['socio']['fech_baja_soc'])?Carbon::parse($data['socio']['fech_baja_soc'])->format('Y-m-d'):null,
                'fecIngr' => isset($data['socio']['fech_iesc_soc'])?Carbon::parse($data['socio']['fech_iesc_soc'])->format('Y-m-d'):null,
                'sexo' => $data['sexo_pers_per'],
                'parentesco' => $data['grad_pare_per']
            ];

    }

    public function findIdenPersPerAndCip($idenpersper, $cip)
    {
         return $this->model->where('iden_pers_per',$idenpersper)->where('codi_ccip_soc',$cip)->where('flag_exte_inf','<>',0)->first();
    }

    public function findNroDNIAndCip($dni, $cip)
    {
       return  $this->model->where('nume_iden_per',$dni)
           ->where('codi_ccip_soc',$cip)
           ->where('flag_exte_inf','<>',0)->first();
    }
}
