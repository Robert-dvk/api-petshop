<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 

use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuarios extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $primaryKey = 'idusuario';

    public $incrementing = true;

    protected $fillable = [
        'nome',
        'telefone',
        'login',
        'senha',
        'isadmin'
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'isadmin' => 'boolean',
    ];

    public $timestamps = false;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
