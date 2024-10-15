<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pccontroi extends Model
{

    protected $connection = 'oracle';
    protected $table = 'pccontroi';
    protected $fillable = [
        'codcontrole',
        'codrotina',
        'codusuario',

    ];

    public function pcempr()
    {
        return $this->belongsTo(Pcempr::class, 'matricula', 'codusuario');
    }

}
