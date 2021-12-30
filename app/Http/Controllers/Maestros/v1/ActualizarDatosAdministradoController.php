<?php

namespace App\Http\Controllers\Maestros\v1;

use App\Http\Controllers\Controller;
use App\Services\ExtInformationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActualizarDatosAdministradoController extends Controller
{
    protected $extInformationService;

    public function __construct(ExtInformationService $extInformationService)
    {
        $this->extInformationService = $extInformationService;
    }
    public function index(){
        $user = optional(auth()->user())->toArray();
        return $this->showAll(collect($this->extInformationService->getAllAuth($user)));
    }
    public function store(Request $request){

        $rules = [
            'apelPat' => 'required|string',
            'apelMat' => 'required|string',
            'nombComp' => 'required|string',
            'nroIdentidad' => 'required|string|min:8|max:8',
            'estacivil' => 'required',
            'sexo' => 'required',
            'fecNac' => 'required|date',
            'email' => 'required|email',
            'telfijo' => 'nullable|min:7',
            'celular' => 'required|min:9',
            'nroDpt' => 'required',
            'nroProv' => 'required',
            'nroDis' => 'required',
            'datoDom' => 'required|string',
            'grado' => 'required',
            'situacion' => 'required',
            'parentesco'=>'nullable',
            'fecRet' => 'nullable|date',
        ];

        $validated = Validator::make($request->all(),$rules,$this->messages());

        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        $user = auth()->user()->toArray();
        $info = $this->extInformationService->store($request,$user);

        if($info){
            return $this->successResponseStatus("Registrado con éxito");
        }else{
            return $this->errorResponse("El administrado ya se encuentra registrado");
        }


    }
    public function update(Request $request,$id){
        $rules = [
            'apelPat' => 'required|string',
            'apelMat' => 'required|string',
            'nombComp' => 'required|string',
            'nroIdentidad' => 'required|string|min:8|max:8',
            'estacivil' => 'required',
            'sexo' => 'required',
            'fecNac' => 'required|date',
            'email' => 'required|email',
            'telfijo' => 'nullable|min:7',
            'celular' => 'required|min:9',
            'nroDpt' => 'required',
            'nroProv' => 'required',
            'nroDis' => 'required',
            'datoDom' => 'required|string',
            'grado' => 'required',
            'situacion' => 'required',
            'parentesco'=>'nullable',
            'fecRet' => 'nullable|date',
        ];
        $validated = Validator::make($request->all(),$rules,$this->messages());
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        $user = auth()->user()->toArray();
        $info = $this->extInformationService->update($request,$user,$id);
        if($info){
            return $this->successResponseStatus("Actualizado con éxito");
        }else{
            return $this->errorResponse("No se encotó el recurso.");
        }


    }
    public function storeAndUpdate(Request $request){

        $rules = [
            'apelPat' => 'required|string',
            'apelMat' => 'required|string',
            'nombComp' => 'required|string',
            'nroIdentidad' => 'required|string|min:8|max:8',
            'estacivil' => 'required',
            'sexo' => 'required',
            'fecNac' => 'required|date',
            'email' => 'required|email',
            'telfijo' => 'nullable|min:7',
            'celular' => 'required|min:9',
            'nroDpt' => 'required',
            'nroProv' => 'required',
            'nroDis' => 'required',
            'datoDom' => 'required|string',
            'grado' => 'required',
            'situacion' => 'required',
            'parentesco'=>'nullable',
            'fecRet' => 'nullable|date',
            'beneficiarios' => 'required|array'
        ];
        $validated = Validator::make($request->all(),$rules,$this->messages());
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        $user = auth()->user()->toArray();
        $data = $this->extInformationService->storeAndUpdate($request,$user);
        return $this->showAll(collect($data));
    }

    public function messages()
    {
        return [
            'apelPat.required' => 'El campo apellido paterno no puede ser vacío.',
            'apelMat.required' => 'El campo apellido materno no puede ser vacío.',
            'nombComp.required' => 'El campo nombres completos no pueden ser vacíos.',
            'nroIdentidad.required' => 'El campo Nro. Doc. Indentidad no puede ser vacío.',
            'nroIdentidad.min' => 'El campo Nro. Doc. Indentidad debe contener al menos 8 caracteres.',
            'nroIdentidad.max' => 'El campo Nro. Doc. Indentidad debe contener menos de 8 caracteres.',
            'estacivil.required' => 'El campo estado civil no pueden ser vacío.',
            'sexo.required' => 'El campo género no pueden ser vacío.',
            'fecNac.required' => 'El campo fecha de nacimiento no pueden ser vacío.',
            'fecNac.date' => 'El campo fecha de nacimiento tiene que ser de tipo fecha.',
            'email.required' => 'El campo correo electrónico no pueden ser vacío.',
            'telfijo.min' => 'El campo teléfono debe contener al menos 7 caracteres.',
            'celular.required' => 'El campo celular no pueden ser vacío.',
            'celular.min' => 'El campo celular debe contener al menos 9 caracteres.',
            'nroDpt.required' => 'El campo departamento no pueden ser vacío.',
            'nroProv.required' => 'El campo provincia no pueden ser vacío.',
            'nroDis.required' => 'El campo distrito no pueden ser vacío.',
            'datoDom.required' => 'El campo dirección no pueden ser vacío.',
            'grado.required' => 'El campo grado no pueden ser vacío.',
            'situacion.required' => 'El campo situación no pueden ser vacío.',
            'fecRet.date' => 'El campo fecha retiro tiene que ser de tipo fecha.',
            'beneficiarios.required' => 'El atributo beneficiarios es obligatorio.',
            'beneficiarios.array' => 'El atributo beneficiarios tiene que ser un array.'
        ];
    }


}
