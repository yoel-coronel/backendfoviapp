<?php

namespace App\Http\Controllers\Auth\v1;

use App\Events\WelcomeNewUser;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterUserController extends Controller
{
    protected $userService = null;
    /**
     * Create a new RegisterUserController instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['register']]);

        $this->userService = $userService;
    }

    public function register(Request $request){

        $rules = [
            'cip' =>'required|min:6|max:8|string',
            'codofin' =>'required|max:9|string',
            'telephone' =>'required|max:9',
            'email' =>'required|unique:users|email',
        ];
       $validated = Validator::make($request->all(),$rules);

       if ($validated->fails()){
           return $this->errorResponseFails(collect($validated->errors()->all()));
       }

       $data = $validated->validated();
       $data['cip'] = $this->autoCoplete($data['cip'],8);
       $data['codofin'] = $this->autoCoplete($data['codofin'],9);

        $user = $this->userService->findCip($data['cip']);

        if($user){
            return $this->errorResponseFails(collect(['Este usuario ya se encuentra registrado.']));
        }

       $socio = $this->userService->findSocio($data['cip'],$data['codofin']);

       if(!$socio){
           return $this->errorResponseFails(collect(['No hay resultados con el CIP ingresado.']));
       }
       $data['name'] = $socio->persona->nomb_pers_per;
       $data['last_name'] =  $socio->persona->apel_pate_per . ' ' .  $socio->persona->apel_mate_per;
       $data['identifier'] = $socio->iden_pers_per;
       $clave = Str::upper(Str::random(8));
       $data['password'] = Hash::make($clave);
       $user = $this->userService->store($data);
       $credentials = ['cip'=>$user->cip,'password'=>$clave];
       $token = auth()->attempt($credentials);
       event(new WelcomeNewUser($user,$clave));
       return $this->respondWithToken($token);
    }
}
