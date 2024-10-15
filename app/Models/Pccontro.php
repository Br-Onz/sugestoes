<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pccontro extends Model
{
    protected $connection = 'oracle';
    protected $table = 'pccontro';
    protected $fillable = [
        'codusuario',
        'codrotina',
        'acesso',


    ];
}
