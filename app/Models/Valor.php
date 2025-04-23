<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valor extends Model
{
    protected $table = 'valores';

    protected $fillable = [
        'temperatura',
        'humedad',
        'uv',
        'fecha',
        'hora',
    ];
}
