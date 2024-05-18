<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\UsuariosRepository;
use Illuminate\Http\JsonResponse;

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

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $response = $this->usuariosRepository->login($request->input('login'), $request->input('senha'));

            return response()->json($response, $response['status'] === 'success' ? 200 : 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao tentar fazer login',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
