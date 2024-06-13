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

        if ($agenda && $agenda->update($data)) {
            ServicosAgenda::where('idagenda', $id)->delete();
            if (isset($data['servicos']) && is_array($data['servicos'])) {
                foreach ($data['servicos'] as $servicoId) {
                    ServicosAgenda::create([
                        'idagenda' => $id,
                        'idservico' => $servicoId
                    ]);
                }
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
            ->select('agenda.*', 'servicos.nome as servico_nome', 'pets.nome as pet_nome', 'servicos.valor as servico_valor')
            ->get();

        return [
            'status' => 'success',
            'data' => $agendamentos
        ];
    }
}
