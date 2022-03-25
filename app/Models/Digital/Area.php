<?php

namespace App\Models\Digital;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $connection = "sqlsrv2";

    protected $fillable = ['nombre','codigo_sifo'];

}
