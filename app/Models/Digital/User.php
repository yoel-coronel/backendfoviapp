<?php

namespace App\Models\Digital;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = "sqlsrv2";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','area','cargo','apellidopat','apellidomat','nombres','dni','estado','area_id'
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

}
