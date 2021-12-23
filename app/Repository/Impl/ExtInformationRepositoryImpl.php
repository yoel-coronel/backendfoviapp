<?php

namespace App\Repository\Impl;

use App\Models\Oracle\ExtInformacion;
use App\Models\Oracle\MaePersona;
use App\Models\User;
use App\Repository\ExtInformationRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExtInformationRepositoryImpl implements ExtInformationRepository
{
    protected $model;
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(ExtInformacion $extInformacion)
    {
        $this->model = $extInformacion;
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

    public function update(array $data, $id)
    {
        $extInfo = $this->model->where('iden_exte_inf', $id)->first();
        $extInfo->iden_exte_inf=$data['iden_exte_inf'];
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

        $data['iden_pers_per']=$user['identifier'];
        $data['cip']=$user['cip'];
        $data['codofin']=$user['codofin'];

        if (!$extInformacion){
            $extInformacion = $this->create($data);
        }else{
            $data['iden_exte_inf'] = $extInformacion->iden_exte_inf;
            $extInformacion = $this->update($data,$extInformacion->iden_exte_inf);
        }

        $datos = collect($request->beneficiarios);

        if ($datos->count()>0){

            foreach ($datos as $kay=>$data){

                $data['iden_extp_inf'] = $extInformacion->iden_exte_inf;

                $extInformacion1 = $this->findNroDNIAndCip($data['nroIdentidad'],$user['cip']);

                $data['iden_pers_per']=null;
                $data['cip']=$user['cip'];
                $data['codofin']=$user['codofin'];
                if (!$extInformacion1){
                    $extInformacion1 = $this->create($data);
                }else{

                    $data['iden_exte_inf'] = $extInformacion1->iden_exte_inf;
                    $extInformacion1 = $this->update($data,$extInformacion1->iden_exte_inf);
                }

            }

        }

        $usr = User::find($user['id']);
        $usr->is_active=1;
        $usr->save();

        return $extInformacion;

    }
    public function getBeneficiarios(array $user)
    {

        $extInformacion = $this->model->where('iden_pers_per',$user['identifier'])->where('codi_ccip_soc',$user['cip'])->where('flag_exte_inf','<>',0)->first();
        if ($extInformacion){
            $extInformacions = $this->model->where('iden_extp_inf',$extInformacion->iden_exte_inf)->where('codi_ccip_soc',$user['cip'])->where('flag_exte_inf','<>',0)->get();
        }else{
            $extInformacions = new Collection();
        }

        $extInformacions_form = new Collection();

        if($extInformacion){
            $extInformacions_form->put('administrado',
                [
                    'id' => $extInformacion['iden_exte_inf'],
                    'nroIdentidad' => $extInformacion['nume_iden_per'],
                    'apelPat' => $extInformacion['apel_pate_per'],
                    'apelMat' => $extInformacion['apel_mate_per'],
                    'nombComp' => $extInformacion['nomb_pers_per'],
                    'estacivil' => $extInformacion['esta_civi_per'],
                    'email' => $extInformacion['corr_prin_per'],
                    'celular' => $extInformacion['celu_prin_per'],
                    'telfijo' => $extInformacion['tlfn_prin_per'],
                    'nroDpt' => null,
                    'nroProv' => null,
                    'nroDis' => $extInformacion['ubig_domi_per'],
                    'datoDom' => $extInformacion['dire_domi_per'],
                    'fecNac' => isset($extInformacion['fech_naci_per'])?Carbon::parse($extInformacion['fech_naci_per'])->format('Y-m-d'):null,
                    'grado' => $extInformacion['codi_grad_soc'],
                    'situacion' => $extInformacion['codi_situ_soc'],
                    'fecRet' => isset($extInformacion['fech_baja_soc'])?Carbon::parse($extInformacion['fech_baja_soc'])->format('Y-m-d'):null,
                    'fecIngr' => isset($extInformacion['fech_iesc_soc'])?Carbon::parse($extInformacion['fech_iesc_soc'])->format('Y-m-d'):null,
                    'sexo' => $extInformacion['sexo_pers_per'],
                    'parentesco' => $extInformacion['grad_pare_per']]);
        }else{

            $administrado = MaePersona::with('socio')->where('iden_pers_per',$user['identifier'])->first();
            $extInformacions_form->put('administrado',
                [
                    'id' => null,
                    'nroIdentidad' => $administrado['nume_iden_per'],
                    'apelPat' => $administrado['apel_pate_per'],
                    'apelMat' => $administrado['apel_mate_per'],
                    'nombComp' => $administrado['nomb_pers_per'],
                    'estacivil' => $administrado['esta_civi_per'],
                    'email' => $user['email'],
                    'celular' => $user['telephone'],
                    'telfijo' => $administrado['nume_telc_per'],
                    'nroDpt' => null,
                    'nroProv' => null,
                    'nroDis' => $administrado['ubig_resi_per'],
                    'datoDom' => $administrado['dire_pers_per'],
                    'fecNac' => isset($administrado['fech_naci_per'])?Carbon::parse($administrado['fech_naci_per'])->format('Y-m-d'):null,
                    'grado' => $administrado['socio']['codi_grad_soc'],
                    'situacion' => $administrado['socio']['codi_situ_soc'],
                    'fecRet' => isset($administrado['socio']['fech_baja_soc'])?Carbon::parse($administrado['socio']['fech_baja_soc'])->format('Y-m-d'):null,
                    'fecIngr' => isset($administrado['socio']['fech_iesc_soc'])?Carbon::parse($administrado['socio']['fech_iesc_soc'])->format('Y-m-d'):null,
                    'sexo' => $administrado['sexo_pers_per'],
                    'parentesco' => $administrado['grad_pare_per']]);
        }

        $beneficiarios = new Collection();

        if ($extInformacions->count()>0){
            foreach ($extInformacions as $key=>$item) {
                $beneficiarios->push([
                    'id' => $item['iden_exte_inf'],
                    'nroIdentidad' => $item['nume_iden_per'],
                    'apelPat' => $item['apel_pate_per'],
                    'apelMat' => $item['apel_mate_per'],
                    'nombComp' => $item['nomb_pers_per'],
                    'estacivil' => $item['esta_civi_per'],
                    'email' => $item['corr_prin_per'],
                    'celular' => $item['celu_prin_per'],
                    'telfijo' => $item['tlfn_prin_per'],
                    'nroDpt' => null,
                    'nroProv' => null,
                    'nroDis' => $item['ubig_domi_per'],
                    'datoDom' => $item['dire_domi_per'],
                    'fecNac' => isset($item['fech_naci_per'])?Carbon::parse($item['fech_naci_per'])->format('Y-m-d'):null,
                    'grado' => $item['codi_grad_soc'],
                    'situacion' => $item['codi_situ_soc'],
                    'fecRet' => isset($item['fech_baja_soc'])?Carbon::parse($item['fech_baja_soc'])->format('Y-m-d'):null,
                    'fecIngr' => isset($item['fech_iesc_soc'])?Carbon::parse($item['fech_iesc_soc'])->format('Y-m-d'):null,
                    'sexo' => $item['sexo_pers_per'],
                    'parentesco' => $item['grad_pare_per']
                ]);
            }

        }
        return $extInformacions_form->put('beneficiarios',$beneficiarios);
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
