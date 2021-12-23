<?php

namespace App\Http\Controllers\Simulaciones\v1;

use App\Http\Controllers\Controller;
use App\Services\SimulationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SimulationController extends Controller
{
    protected $simulationService;

    public function __construct(SimulationService $simulationService)
    {
        $this->simulationService = $simulationService;
    }
    public function getAllSimulationUserAuth(){
        $user = optional(auth()->user())->toArray();
        return $this->simulationService->getAllSimulationUserAuth($user);
    }
    public function capacidadMaxima(){
        return $this->showAll(collect($this->simulationService->capacidadMaxSimulation(auth()->id())));
    }
    public function simularPrestamo(Request $request){
        $rules = [
             'ingr_brto_sim' =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
             'boni_ingr_ofi' =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
             'dsct_ofic_sim' =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
             'deud_otra_sim' =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
             'dsct_pers_sim' =>'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
             'plaz_pres_sim' =>'required|numeric',
             'product_id' => 'required|numeric',
             'line_product_id' => 'required|numeric',
        ];
        $validated = Validator::make($request->all(),$rules,$this->messages());
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        $data = $validated->validate();

        $valida_data = $this->simulationService->capacidadMaxSimulation(auth()->id());

        if($valida_data['enabled_simulation']){

            $simulation['codper'] = optional(auth()->user())->identifier;
            $simulation['idenProdPrd'] = $valida_data['product_id'];
            $simulation['codlineapro'] = $valida_data['line_product_id'];
            $simulation['ingrBrtoSim'] = $data['ingr_brto_sim'];
            $simulation['boniIngrOfi'] = floatval($valida_data['additional_bonus']);
            $simulation['dsctOficSim'] = $data['dsct_ofic_sim'];
            $simulation['dsctPersSim'] = $data['dsct_pers_sim'];
            $simulation['deudOtraSim'] = $data['deud_otra_sim'];
            $simulation['plazPresSim'] = $data['plaz_pres_sim'];

            $simulation['idenPersFam'] = null;
            $simulation['coddesc'] = null;
            $simulation['codnive'] = null;
            $simulation['obseSimuSim'] = null;
            $simulation['codsegu'] = 1;
            $simulation['monfina'] = null;
            $simulation['impoGiraSim'] = null;
            $simulation['usuaCreaAud'] = optional(auth()->user())->cip;
            $simulation['codmone'] = 1;
            $simulation['nombEquiAud'] = $request->ip();

            $resp = $this->simulationService->simularPrestamo($simulation);

            if(intval( $resp['error']) === 1){
                return $this->errorResponse($resp['mensaje'],1,404);
            }
            return $this->successResponseStatus($resp['mensaje']);

        }


    }

    public function messages()
    {
        return [
            'ingr_brto_sim.required' => 'El campo ingreso bruto o remuneración consolidada es requerido.',
            'boni_ingr_ofi.required' => 'El campo bonificación ó bonus es requerido.',
            'dsct_ofic_sim.required' => 'El campo descuentos oficiales es requerido.',
            'deud_otra_sim.required' => 'El campo deudas financieras es requerido.',
            'dsct_pers_sim.required' => 'El campo deudas personales es requerido.',
            'plaz_pres_sim.required' => 'El campo plazo o periodo es requerido.',
            'product_id.required' => 'El campo el producto es requerido.',
            'line_product_id.required' => 'El campo linea producto es requerido.',
            'ingr_brto_sim.regex' => 'El formato del ingreso bruto o remuneración consolidada no es válido.',
            'boni_ingr_ofi.regex' => 'El formato de  bonificación ó bonus no es válido.',
            'dsct_ofic_sim.regex' => 'El formato de  descuentos oficiales no es válido.',
            'deud_otra_sim.regex' => 'El formato de  descuentos oficiales no es válido.',
            'dsct_pers_sim.regex' => 'El formato de  deudas personales no es válido.',
            'ingr_brto_sim.numeric' => 'El campo ingreso bruto o remuneración consolidada debe ser número.',
            'boni_ingr_ofi.numeric' => 'El campo bonificación ó bonus debe ser número.',
            'dsct_ofic_sim.numeric' => 'El campo descuentos oficiales debe ser número.',
            'deud_otra_sim.numeric' => 'El  campo deudas financieras debe ser número.',
            'plaz_pres_sim.numeric' => 'El  campo  plazo o periodo debe ser número.',
            'dsct_pers_sim.numeric' => 'El  campo  deudas personales debe ser número.',
        ];
    }
}
