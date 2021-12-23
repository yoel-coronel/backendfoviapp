<?php

namespace App\Services\Impl;

use App\Models\Oracle\MaeSocio;
use App\Repository\UserRepository;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
    protected $userReposiotry = null;

    public function __construct(UserRepository $userReposiotry)
    {
        $this->userReposiotry = $userReposiotry;
    }

    public function store(array  $data)
    {
        return $this->userReposiotry->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->userReposiotry->update($data,$id);
    }
    public function findSocio($cip, $codofi)
    {
        return MaeSocio::with('persona')
                        ->where('codi_ccip_soc',$cip)
                        ->where('codi_cdfi_soc',$codofi)
                        ->where('flag_esta_soc','<>',0)
                        ->first();
    }

    public function findCip($cip)
    {
       return $this->userReposiotry->findCip($cip);
    }

    public function verificaToken($email,$token)
    {
        $verificacion = false;
        $resPass = $this->userReposiotry->findEmail($email);
        $time = config('app.time_token_verification');
        $tokens =  (array)(DB::table    ("password_resets")->select('email','token','created_at')->where('email',$email)->get())->last();

        if($tokens){

            if (Hash::check($token, $tokens['token']))
            {
                $fecha_y_hora_actaul = now();
                $fecha_y_hora_creado = Carbon::parse($tokens['created_at'])->addMinute($time);
                if($fecha_y_hora_actaul <= $fecha_y_hora_creado){
                    $verificacion = true;
                }

            }
        }
        return $verificacion;

    }


}
