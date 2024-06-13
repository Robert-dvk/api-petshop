<?php
namespace App\Repositories;

use App\Models\{
    Agenda,
    ServicosAgenda
};

use Illuminate\Support\Facades\DB;

class AgendaRepository
{
    public function all()
    {
        return Agenda::all();
    }

    public function store($data)
    {
        $agendaData = [
            'data' => $data['data'],
            'hora' => $data['hora'],
            'idusuario' => $data['idusuario'],
            'idpet' => $data['idpet']
        ];
        
        $agenda = Agenda::create($agendaData);

        return [
            'status' => 'success',
            'data' => $agenda
        ];
    }

    public function storeServicosAgenda($request)
    {
        $agenda = ServicosAgenda::create([
            'idagenda' => $request["idagenda"],
            'idservico' => $request["idservico"]
        ]);

        return [
            'status' => 'success',
            'data' => $agenda
        ];
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $agenda = Agenda::find($id);

            if ($agenda) {
                ServicosAgenda::where('idagenda', $id)->delete();

                $agenda->delete();

                DB::commit();

                return [
                    'status' => 'success',
                    'message' => 'Agenda excluída com sucesso'
                ];
            } else {
                DB::rollBack();

                return [
                    'status' => 'error',
                    'message' => 'Agendamento não encontrado'
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Falha ao excluir a agenda: ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data)
    {
        $agenda = Agenda::find($id);
        if ($agenda) {
            $agenda->update($data);

            if (isset($data['idservico'])) {
                $servicoId = $data['idservico'];

                ServicosAgenda::where('idagenda', $id)->delete();

                ServicosAgenda::create([
                    'idagenda' => $id,
                    'idservico' => $servicoId
                ]);
            }

            return [
                'status' => 'success',
                'data' => $agenda
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Falha ao atualizar a agenda'
            ];
        }
    }
    
    public function getAgendamentosByUser($userId)
    {
        $agendamentos = Agenda::where('agenda.idusuario', $userId)
            ->join('servicosagenda', 'agenda.idagenda', '=', 'servicosagenda.idagenda')
            ->join('servicos', 'servicosagenda.idservico', '=', 'servicos.idservico')
            ->join('pets', 'agenda.idpet', '=', 'pets.idpet')
            ->select('agenda.*', 'servicos.nome as servico_nome', 'pets.nome as pet_nome', 'servicos.idservico as servico_id', 'servicos.valor as servico_valor')
            ->get();

        return [
            'status' => 'success',
            'data' => $agendamentos
        ];
    }
    public function editarServicosAgenda($id)
    {
        try {
            $agenda = Agenda::find($id);

            if (!$agenda) {
                return [
                    'status' => 'error',
                    'message' => 'Agendamento não encontrado.'
                ];
            }

            $servicoId = request()->input('idservico');

            if (empty($servicoId)) {
                return [
                    'status' => 'error',
                    'message' => 'Nenhum serviço fornecido para atualização.'
                ];
            }

            // Deleta o serviço existente se houver
            ServicosAgenda::where('idagenda', $id)->delete();

            ServicosAgenda::create([
                'idagenda' => $id,
                'idservico' => $servicoId
            ]);

            return [
                'status' => 'success',
                'message' => 'Serviço do agendamento atualizado com sucesso.'
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Ocorreu um erro ao atualizar o serviço do agendamento.',
                'error' => $e->getMessage()
            ];
        }
    }


}
