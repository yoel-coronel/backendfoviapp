<?php

namespace App\Services\Impl;
use App\Repository\MaeEntidaddetRepository;
use App\Repository\UserRepository;
use App\Services\SimulationService;
use Carbon\Carbon;


class SimulationServiceImpl implements SimulationService
{
    protected $userRepository;
    protected $maeEntidaddetRepository;

    public function __construct(UserRepository $userRepository,MaeEntidaddetRepository $maeEntidaddetRepository)
    {
        $this->userRepository = $userRepository;
        $this->maeEntidaddetRepository = $maeEntidaddetRepository;
    }
    public function capacidadMaxSimulation($id)
    {
         $socio = $this->userRepository->findUserWithSocio($id)->only('codi_grad_soc','codi_situ_soc');
         $grado = $this->maeEntidaddetRepository->getGradoAgrupado($socio['codi_grad_soc']);
         $user = $this->userRepository->find($id);
         $escalaVigente = $this->maeEntidaddetRepository->getEscalaVigente();
         $topeMaximo = $this->maeEntidaddetRepository->getTopeMaximo($escalaVigente->secu_enti_det,$grado->valo_numd_det)->only('valo_cadu_det','valo_decu_det','valo_decd_det');
        $data_prestamo_anterior = json_decode(file_get_contents(config('app.url_simulation').'/api/sifo/verificarPrestamoAnterior/'.$user->identifier), true );
        return [
            'grade_description'=>$topeMaximo['valo_cadu_det'],
            'maximum_capacity'=> number_format((double) $topeMaximo['valo_decu_det'],2),
            'additional_bonus' => ((int)$socio['codi_situ_soc'])===1?number_format((double) $topeMaximo['valo_decd_det'],2):0,
            'product_id' => (int) $data_prestamo_anterior['codigoProducto'],
            'line_product_id' => (int) $data_prestamo_anterior['lineaProducto'],
            'enabled_simulation' => (bool) $data_prestamo_anterior['esAnaf']==true?true:false,
            'message' => $data_prestamo_anterior['esAnaf']==true?"Se ha detectado que usted se encuentra registrado en la ASOCIACIÓN DE ADJUDICATARIOS DE FOVIPOL ANAF, para poder acceder a una ampliación primero debe refinanciar su crédito":null,
            'is_loan_new' =>(bool) $data_prestamo_anterior['esPrestamoNuevo'],
            'maximum_number_of_installments' =>360,
            'person_id' =>$user->identifier,
            'ingr_brto_sim' =>0,
            'boni_ingr_ofi' =>0,
            'dsct_ofic_sim' =>0,
            'deud_otra_sim' =>0,
            'plaz_pres_sim' =>0,
            'years'=>30,
        ];
    }
    public function simularPrestamo(array $data)
    {
        $url = config('app.url_simulation').'/api/sifo/generarSimulacion';
        $curl = curl_init();

        $body = array(
            "idenpers" => array("codper" => $data['codper']),
            "idenPersFam"=> null,
            "idenProdPrd"=>$data['idenProdPrd'],
            "codlineapro"=>$data['codlineapro'],
            "ingrBrtoSim"=>$data['ingrBrtoSim'],
            "boniIngrOfi"=>$data['boniIngrOfi'],
            "dsctOficSim"=>$data['dsctOficSim'],
            "dsctPersSim"=>$data['dsctPersSim'],
            "deudOtraSim"=>$data['deudOtraSim'],
            "coddesc"=> null,
            "codnive"=> null,
            "obseSimuSim"=> null,
            "codsegu"=> 1,
            "plazPresSim"=>  $data['plazPresSim'],
            "monfina"=> null,
            "impoGiraSim"=> null,
            "usuaCreaAud"=> $data['usuaCreaAud'],
            "codmone"=> 1,
            "nombEquiAud"=> $data['nombEquiAud']
        );

        curl_setopt_array($curl, array(
                CURLOPT_URL =>$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "Accept: application/json"
                ),
            )
        );
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if($response){
            return json_decode($response , true);
        }
        return $err;
    }
    public function getAllSimulationUserAuth(array $user)
    {
        $simulaciones = json_decode(file_get_contents(config('app.url_simulation').'/api/sifo/verSimulaciones/'.$user['identifier'].'/'.$user['cip']), true );
        $data_prestamo_anterior = json_decode(file_get_contents(config('app.url_simulation').'/api/sifo/verificarPrestamoAnterior/'.$user['identifier']), true );
        $simulaciones = collect($simulaciones['simulaciones']);

        $simulaciones = $simulaciones->map(function ($item){
            return [
                'id' => $item['idenSimuSim'],
                'tasa' =>$item['tasaTeaSim'],
                'impo_soli_sim' =>number_format($item['impoSoliSim'],2),
                'impo_cuot_sim' => number_format($item['impoCuotSim'],2),
                'created_at' => $item['fechCreaAud'],
                'person_id' =>$item['idenpers']['codper'],
                'parametros_simulacion' => [
                    'ingr_brto_sim' => number_format($item['ingrBrtoSim'],2),
                    'boni_ingr_ofi' => number_format($item['boniIngrOfi'],2),
                    'dsct_ofic_sim' =>number_format($item['dsctOficSim'],2),
                    'dsct_pers_sim' =>number_format($item['dsctPersSim'],2),
                    'deud_otra_sim' =>number_format($item['deudOtraSim'],2),
                    'impo_gira_sim' =>number_format($item['impoGiraSim'],2),
                    'impo_gadm_sim' =>number_format($item['impoGadmSim'],2),
                    'otrs_dsct_sim' =>number_format($item['otrsDsctSim'],2),
                    'desc_dsct_sim' =>number_format($item['descDsctSim'],2),
                    'plaz_pres_sim' =>number_format($item['plazPresSim'],2),
                ],
                'lineapro' =>$item['lineapro'],
                'producto' =>$item['producto'],
                'moneda' =>$item['moneda'],
                'poliza' =>$item['poliza'],
            ];
        });

        return [
            'information_person' =>[
                'full_name' =>optional(auth()->user())->getFullName(),
                'cip'=>optional(auth()->user())->cip,
                'edad' =>optional(auth()->user())->age(Carbon::parse((optional(auth()->user())->person->fech_naci_per))),
                'grado' =>optional(auth()->user())->grado(optional(auth()->user())->socio->codi_grad_soc),
                'fecha_nacimiento' =>Carbon::parse(optional(auth()->user())->person->fech_naci_per)->format('d/m/Y'),
                'dni' =>optional(auth()->user())->person->nume_iden_per,
            ],
            'simulaciones' => $simulaciones,
            'informacion_prestamo_aterior' =>$data_prestamo_anterior
        ];
    }
}
