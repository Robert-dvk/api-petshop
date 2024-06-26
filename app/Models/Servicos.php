<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    use HasFactory;

    protected $primaryKey = 'idservico';

    public $incrementing = true;

    protected $fillable = [
        'nome', 
        'valor'
    ];

    public $timestamps = false;
}
