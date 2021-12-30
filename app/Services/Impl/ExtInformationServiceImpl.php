<?php

namespace App\Services\Impl;

use App\Repository\ExtInformationRepository;
use App\Services\ExtInformationService;
use Illuminate\Http\Request;

class ExtInformationServiceImpl implements ExtInformationService
{
    protected $extInformationRepository;

    public function __construct(ExtInformationRepository $extInformationRepository)
    {
        $this->extInformationRepository = $extInformationRepository;
    }

    public function storeAndUpdate(Request $request,array $user)
    {
        return $this->extInformationRepository->storeAndUpdate($request,$user);
    }

    public function store(Request $request, array $user)
    {
        $data = $request->all();
        $inform = $this->extInformationRepository->findIdenPersPerAndCip($user['identifier'],$user['cip']);

        if(!$inform){
            $data['iden_pers_per'] = $user['identifier'];
            $data['cip']=$user['cip'];
            $data['codofin']=$user['codofin'];
            return $this->extInformationRepository->create($data);
        }else{
            return null;
        }
    }
    public function update(Request $request, array $user,$id)
    {
        $extInformacion = $this->extInformationRepository->find($id);
        if($extInformacion){
            $data = $request->all();
            $data['iden_pers_per']=$extInformacion->iden_pers_per;
            $data['cip']=$user['cip'];
            $data['codofin']=$user['codofin'];
            $data['iden_exte_inf'] = $extInformacion->iden_exte_inf;
            $data['iden_extp_inf'] = $extInformacion->iden_extp_inf;
            return $this->extInformationRepository->update($data,$id);
        }else{
            return null;
        }

    }

    public function getAllAuth(array $user)
    {
        return $this->extInformationRepository->getBeneficiarios($user);
    }
}
