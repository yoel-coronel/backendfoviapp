<?php

namespace App\Models;

use App\Models\Oracle\MaeEntidaddet;
use App\Models\Oracle\MaePersona;
use App\Models\Oracle\MaeSocio;
use Carbon\Carbon;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use /*HasApiTokens, HasFactory,*/ Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_name', 'telephone', 'identifier',
        'cip', 'codofin','is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'identifier'=>'integer'
    ];
    /**
     * Relation
     */

    public function getFullName() {
        return $this->name.' '.$this->last_name;
    }

    public function getFirstName() {
        $parts_name = explode(' ', $this->name);
        return $parts_name[0] . ( isset($parts_name[1]) && strlen($parts_name[1]) > 0 ? (' ' . $parts_name[1][0] . '.'  ) : '' );
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function age($birthDate)
    {
        return (int) $birthDate->diff(Carbon::now())->format('%y');
    }
    public function grado($code)
    {
        $codiEnti = 'CODIGRADSOC';
        return optional(MaeEntidaddet::where('codi_enti_ent', $codiEnti)
            ->where('secu_enti_det', $code)->first())->valo_cadu_det;
    }
    public function person()
    {
        return $this->hasOne(MaePersona::class, 'iden_pers_per', 'identifier');
    }
    public function socio()
    {
        return $this->hasOne(MaeSocio::class, 'iden_pers_per', 'identifier')->where('flag_esta_soc','<>',0);
    }
}
