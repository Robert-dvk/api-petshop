<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicosAgenda extends Model
{
    protected $table = 'servicosagenda';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idservico',
        'idagenda'
    ];

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'idservico');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'idagenda');
    }
}
