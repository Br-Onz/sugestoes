<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pclib extends Model
{

    protected $connection = 'oracle';
    protected $table = 'pclib';

    protected $fillable = [
        'codfunc',
        'codtabela',
        'codigoa',
    ];

    //pcmib
}
