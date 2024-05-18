<?php

namespace App\Repositories;

use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;

class UsuariosRepository
{
    public function all()
    {
        return Usuarios::all();
    }

    public function findByLogin($login)
    {
        return Usuarios::where('login', $login)->first();
    }

    public function login($login, $senha)
    {
        if (empty($login) || empty($senha)) {
            return [
                'status' => 'error',
                'message' => 'O login e a senha são obrigatórios'
            ];
        }
        try {
            $usuario = $this->findByLogin($login);
    
            if (!$usuario || !Hash::check($senha, $usuario->senha)) {
                return [
                    'status' => 'error',
                    'message' => 'Credenciais inválidas'
                ];
            }
    
            return [
                'status' => 'success',
                'message' => 'Login bem-sucedido',
                'usuario' => $usuario
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Ocorreu um erro ao tentar fazer login',
                'error' => $e->getMessage()
            ];
        }
    }
    
}
