<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuarios\{
    LoginRequest,
    CreateUsuarioRequest,
    UpdateUsuarioRequest
};
use App\Repositories\UsuariosRepository;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuariosController extends Controller
{
    protected $usuariosRepository;

    public function __construct(UsuariosRepository $usuariosRepository)
    {
        $this->usuariosRepository = $usuariosRepository;
    }

    public function index()
    {
        return $this->usuariosRepository->all();
    }

    public function login(LoginRequest $request)
    {
        try {
            return $this->usuariosRepository->login($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao tentar fazer login',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(CreateUsuarioRequest $request)
    {
        try {
            $response = $this->usuariosRepository->store($request);

            $statusCode = $response['status'] === 'success' ? 200 : 401;
            
            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao cadastrar o usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function delete($id)
    {
        try {
            $response = $this->usuariosRepository->delete($id);

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao excluir o usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, UpdateUsuarioRequest $request)
    {
        try {
            $response = $this->usuariosRepository->update($id, $request);

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao atualizar o usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getData() {
        try {
            $usuario = JWTAuth::parseToken()->authenticate();
            
            return response()->json([
                'status' => 'success',
                'usuario' => $usuario
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível obter os dados do usuário',
                'error' => config('app.debug') ? $e->getMessage() : 'Erro interno no servidor'
            ], 500);
        }
    }
}
