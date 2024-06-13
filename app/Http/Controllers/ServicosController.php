<?php

namespace App\Http\Controllers;

use App\Http\Requests\Servicos\{
    CreateServicoRequest,
    UpdateServicoRequest
};
use App\Repositories\ServicosRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ServicosController extends Controller
{
    protected $ServicosRepository;

    public function __construct(ServicosRepository $ServicosRepository)
    {
        $this->ServicosRepository = $ServicosRepository;
    }

    public function index()
    {
        return $this->ServicosRepository->all();
    }

    public function store(CreateServicoRequest $request)
    {
        try {
            $response = $this->ServicosRepository->store($request);

            $statusCode = $response['status'] === 'success' ? 200 : 401;
            
            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao cadastrar o serviço',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->ServicosRepository->delete($id);

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao excluir o serviço',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, UpdateServicoRequest $request)
    {
        try {
            $response = $this->ServicosRepository->update($id, $request->all());

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao atualizar o serviço',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
