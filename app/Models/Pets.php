<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    use HasFactory;

    protected $primaryKey = 'idpet';

    public $incrementing = true;

    protected $fillable = [
        'nome', 
        'datanasc', 
        'sexo', 
        'peso', 
        'porte', 
        'altura',
        'imagem',
        'idusuario'
    ];

    public $timestamps = false;
}
