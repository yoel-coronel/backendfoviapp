<?php

namespace App\Models;

use App\Models\Digital\Archivo;
use App\Models\Digital\Area;
use App\Models\Digital\MaeSocio;
use App\Models\Digital\Notification;
use App\Models\Digital\TipoSolicitud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use SoftDeletes;

    protected $connection = "sqlsrv2";

    const ESTADO_ABIERTO='ABIERTO';
    const ESTADO_PROCESO='PROCESO';
    const ESTADO_CERRADO='CERRADO';


    const CONDICION_ENVIADO='ENVIADO';
    const CONDICION_RECIBIDO='RECIBIDO';
    const CONDICION_PENDIENTE='PENDIENTE';



    protected $fillable = [
        'mae_socio_id',
        'area_registra_id',
        'area_envio_id',
        'tipo_solicitud_id',
        'iden_pers_per',
        'user_crea_id',
        'user_recibe_id',
        'user_aprueba_id',
        'descripcion',
        'nombre_admin',
        'cip',
        'dni',
        'estado',
    ];

    public function archivos(){

        return $this->morphMany(Archivo::class, 'modelo');

    }

    public function notifications(){

        return $this->morphMany(Notification::class, 'notificacion');

    }

    public function tipoSolicitud(){

        return $this->belongsTo(TipoSolicitud::class,'tipo_solicitud_id','id');

    }
    public function maeSocio(){

        return $this->belongsTo(MaeSocio::class,'mae_socio_id','id');

    }
    public function userCreaSolicitud(){

        return $this->belongsTo(\App\Models\Digital\User::class,'user_crea_id','id');

    }
    public function areaCrea(){

        return $this->belongsTo(Area::class,'area_registra_id','id');

    }
    public function areaRecibe(){

        return $this->belongsTo(Area::class,'area_envio_id','id');

    }

}
