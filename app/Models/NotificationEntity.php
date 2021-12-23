<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationEntity extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','path','url','identifier','read_at','is_active'];

}
