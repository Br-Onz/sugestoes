<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pcempr extends Model
{
    use HasFactory;
    protected $connection = 'oracle';
    protected $table = 'pcempr';
    protected $primaryKey = 'matricula';
}
