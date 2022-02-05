<?php

namespace App\Http\Controllers\Auth\v1;

use App\Events\ResolveRequestPassword;
use App\Events\SendCodeForEmail;
use App\Events\SendTokenSMS;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    protected $userService = null;
    /**
     * Create a new RegisterUserController instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws \Exception
     */
    protected function sendResetLinkResponse(Request $request)
    {
        $input = $request->only('cip','notification_type');
        $validator = Validator::make($input, [
            'cip' => "required",
            'notification_type'=>"required|in:0,1"
        ]);
        if ($validator->fails()) {
            return $this->errorResponseFails(collect($validator->errors()->all()),1,422);
        }

        $socio = $this->userService->findCip($this->autoCoplete($input['cip'],8));
        if(!$socio){
            return $this->errorResponseFails(collect(['No hay resultados con el CIP ingresado.']));
        }
        try {
            $token = random_int(1000,9999);
        }catch (\Exception $exception){
            return $this->errorResponseFails(collect(['Error en generar el código de verificación.']));
        }

        if(intval($input['notification_type']) === 1){

            event(new SendCodeForEmail($socio,$token));

        }else{

            event(new SendTokenSMS($socio,$token));

        }

        return $this->showAll(collect(['messages'=>['Código enviado con éxito.'],'timeMinutos'=>config('app.time_token_verification')]));
    }
    protected function sendResetResponse(Request $request){

        $input = $request->only('cip', 'password');
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'cip' => 'required|min:6|max:8',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $socio = $this->userService->findCip($this->autoCoplete($input['cip'],8));
        if(!$socio){
            return $this->errorResponseFails(collect(['No hay resultados con el CIP ingresado.']));
        }
        if ( !$this->userService->verificaToken($socio->email,$request->get('token'))){
            return $this->errorResponseFails(collect(['El código de verificación es inválido.']));
        }
        $input['password'] = bcrypt($input['password']);
        $this->userService->update($input,$socio->id);
        event(new ResolveRequestPassword($socio->email));
        return $this->successResponseStatus("Las credenciales se modificó con éxito.");
    }

}
