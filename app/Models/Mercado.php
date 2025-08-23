<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    protected $fillable = [
        'name',
        'preco',
        'marca',
    ];
}
