<?php

namespace App\Repositories;

use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Usuarios\LoginRequest;

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

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $usuario = $this->findByLogin($request->login);

            if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Credenciais inválidas'
                ], 401);
            }

            $token = JWTAuth::fromUser($usuario);

            return response()->json([
                'status' => 'success',
                'message' => 'Login bem-sucedido',
                'usuario' => $usuario,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao tentar fazer login',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno no servidor'
            ], 500);
        }
    }

    public function store($request)
    {
        try {
            $usuario = Usuarios::create([
                'nome' => $request->nome,
                'telefone' => $request->telefone,
                'login' => $request->login,
                'senha' => Hash::make($request->senha), 
                'isadmin' => $request->isadmin ?? false
            ]);

            return [
                'status' => 'success',
                'message' => 'Usuário criado com sucesso',
                'usuario' => $usuario
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Ocorreu um erro ao tentar criar o usuário',
                'error' => $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $usuario = Usuarios::find($id);

            if (!$usuario) {
                return [
                    'status' => 'error',
                    'message' => 'Usuário não encontrado'
                ];
            }

            $usuario->delete();

            return [
                'status' => 'success',
                'message' => 'Usuário excluído com sucesso'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Ocorreu um erro ao tentar excluir o usuário',
                'error' => $e->getMessage()
            ];
        }
    }

    public function update($id, $request)
    {
        try {
            $usuario = Usuarios::find($id);

            if (!$usuario) {
                return [
                    'status' => 'error',
                    'message' => 'Usuário não encontrado'
                ];
            }

            $data = $request->validated();

            if ($data['login'] != $usuario->login) {
                $usuario->update(['login' => $data['login']]);
            }
            if ($data['nome'] != $usuario->nome) {
                $usuario->update(['nome' => $data['nome']]);
            }
            if ($data['telefone'] != $usuario->telefone) {
                $usuario->update(['telefone' => $data['telefone']]);
            }

            return [
                'status' => 'success',
                'message' => 'Usuário atualizado com sucesso',
                'usuario' => $usuario
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Ocorreu um erro ao tentar atualizar o usuário',
                'error' => $e->getMessage()
            ];
        }
    }

    
}
