<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $primaryKey = 'idagenda';

    public $incrementing = true;

    protected $fillable = [
        'data', 
        'hora', 
        'idpet', 
        'idusuario'
    ];

    public $timestamps = false;
}
