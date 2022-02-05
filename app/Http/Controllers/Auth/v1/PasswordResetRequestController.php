<?php

namespace App\Http\Controllers\Auth\v1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PasswordResetRequestController extends Controller
{
    protected $userService = null;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function sendPasswordResetEmail(Request $request){

        if(!$this->validCip($request->cip)){
            return $this->errorResponse("El Cip no esta registrado");
        } else {

            $this->sendMail($request->email);

        }

        return $this->successResponseStatus("Verificar su correo electrónico, se ha enviado un código de verificación");

    }

    protected function validCip($cip) {
        return $this->userService->findCip($cip);
    }

    public function sendMail($email){
      /*  $token = $this->generateToken($email);
        Mail::to($email)->send(new SendMail($token));*/
    }

    public function generateToken($email){
        $isOtherToken = DB::table('recover_password')->where('email', $email)->first();

        if($isOtherToken)
            return $isOtherToken->token;
        $token = Str::random(80);;
        $this->storeToken($token, $email);
        return $token;
    }
    public function storeToken($token, $email){
        DB::table('recover_password')->insert([
            'email' => $email,
            'token' => $token,
            'created' => Carbon::now()
        ]);

    }



}
