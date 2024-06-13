<?php
namespace App\Http\Controllers;

use App\Http\Requests\Agenda\{
    CreateAgendaRequest,
    UpdateAgendaRequest,
    CreateServicosAgendaRequest,
};
use App\Repositories\AgendaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    protected $agendaRepository;

    public function __construct(AgendaRepository $agendaRepository)
    {
        $this->agendaRepository = $agendaRepository;
    }

    public function index()
    {
        return $this->agendaRepository->all();
    }

    public function store(CreateAgendaRequest $request)
    {
        try {
            $response = $this->agendaRepository->store($request->validated());

            $statusCode = $response['status'] === 'success' ? 200 : 401;
            
            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao cadastrar a agenda',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeServicosAgenda(CreateServicosAgendaRequest $request)
    {
        try {
            $response = $this->agendaRepository->storeServicosAgenda($request->validated());

            $statusCode = $response['status'] === 'success' ? 200 : 401;
            
            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao cadastrar a serviços na agenda',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->agendaRepository->delete($id);

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao excluir a agenda',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update($id, UpdateAgendaRequest $request)
    {
        try {
            $response = $this->agendaRepository->update($id, $request->validated());

            $statusCode = $response['status'] === 'success' ? 200 : 401;

            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao atualizar a agenda',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAgendamentosByUser()
    {
        try {
            $user = Auth::user();
            $response = $this->agendaRepository->getAgendamentosByUser($user->idusuario);
            $statusCode = $response['status'] === 'success' ? 200 : 400;
            return response()->json($response, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocorreu um erro ao buscar os agendamentos do usuário',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
