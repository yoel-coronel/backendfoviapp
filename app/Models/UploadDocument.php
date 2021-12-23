<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadDocument extends Model
{
    use HasFactory;

     const STATUS_SIN_PROCESAR ='SIN PROCESAR';
     const STATUS_PROCESANDO ='PROCESANDO';
     const STATUS_PROCESADO ='PROCESADO';
     const STATUS_MESA_PARTES='MESA_PARTES';

    protected $fillable = ['uuid','identifier','cip','procedure_id','sub_procedure_id','user_id','year','month','day','name','path','size','extension','description','reason','status','is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
