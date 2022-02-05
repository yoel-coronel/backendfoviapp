<?php

namespace App\Models\Zkbiotime;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IclockTransaction extends Model
{
    use HasFactory;


    protected $table = 'ICLOCK_TRANSACTION';
    protected $connection = 'sqlsrv1';

}
