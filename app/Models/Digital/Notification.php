<?php

namespace App\Models\Digital;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $connection = "sqlsrv2";

    const ESTADO_EVNIO="ENVIADO";
    const PENDIENTE_ESTADO="PENDIENTE";

    protected $fillable = [
        'notificacion_id',
        'notificacion_type',
        'descripcion',
        'codigo_envio'
    ];

    public function notificacion(){

        return $this->morphTo();

    }

}
