<?php

namespace App\Models\Digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archivo extends Model
{
    use SoftDeletes;

    protected $connection = "sqlsrv2";

    protected $fillable = [
        'modelo_id',
        'modelo_type',
        'title',
        'descripcion',
        'path',
        'is_envio'
    ];

    public function modelo(){
        return $this->morphTo();
    }

}
