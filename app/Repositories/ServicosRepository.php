<?php
namespace App\Repositories;

use App\Models\Servicos;

class ServicosRepository
{
    public function all()
    {
        return Servicos::all();
    }

    public function store($request)
    {
        $servicoData = $request->validated();
        $servico = Servicos::create($servicoData);

        if ($servico) {
            return [
                'status' => 'success',
                'data' => $servico
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Falha ao cadastrar o serviço'
            ];
        }
    }

    public function delete($id)
    {
        $servico = Servicos::find($id);

        if ($servico && $servico->delete()) {
            return [
                'status' => 'success',
                'message' => 'Serviço excluído com sucesso'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Falha ao excluir o serviço'
            ];
        }
    }

    public function update($id, $data)
    {
        $servico = Servicos::find($id);

        if ($servico && $servico->update($data)) {
            return [
                'status' => 'success',
                'data' => $servico
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Falha ao atualizar o serviço'
            ];
        }
    }
}
