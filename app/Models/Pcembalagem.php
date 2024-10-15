<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcembalagem extends Model
{
    use HasFactory;

    protected $connection = 'oracle';
    protected $table = 'pcembalagem';
    protected $primaryKey = 'codprod';

    protected $fillable = [
        'codprod',
        'codauxiliar',
        'ptabela',
        'pvenda',
    ];

}
