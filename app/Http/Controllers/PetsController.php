<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pets\{
    CreatePetRequest,
    UpdatePetRequest
};
use App\Repositories\PetsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PetsController extends Controller
{
    protected $petsRepository;

    public function __construct(PetsRepository $petsRepository)
    {
        $this->petsRepository = $petsRepository;
    }

    public function index()
    {
        return $this->petsRepository->all();
    }

    public function store(CreatePetRequest $request)
    {
        try {
            $response = $this->petsRepository->store($request);

            $statusCode = $response['status'] === 'success' ? 200 : 401;
            
            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao cadastrar o pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->petsRepository->delete($id);

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao excluir o pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, UpdatePetRequest $request)
    {
        try {
            $response = $this->petsRepository->update($id, $request->all());

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao atualizar o pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPetsByUser()
    {
        try {
            $user = Auth::user();
            $pets = $this->petsRepository->getPetsByUser($user->idusuario);

            return response()->json([
                'status' => 'success',
                'data' => $pets
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao buscar os pets do usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
