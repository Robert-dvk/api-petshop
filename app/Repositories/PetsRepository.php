<?php

namespace App\Repositories;

use App\Models\Pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetsRepository
{
    public function all()
    {
        return Pets::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $pet = new Pets($validatedData);

        if ($pet->save()) {
            return ['status' => 'success', 'message' => 'Pet cadastrado com sucesso'];
        }

        return ['status' => 'error', 'message' => 'Erro ao cadastrar o pet'];
    }

    public function delete($id)
    {
        $pet = Pets::find($id);
        if ($pet && $pet->delete()) {
            return ['status' => 'success', 'message' => 'Pet excluído com sucesso'];
        }

        return ['status' => 'error', 'message' => 'Erro ao excluir o pet'];
    }

    public function update($id, array $data)
    {
        $pet = Pets::find($id);
        if (!$pet) {
            return ['status' => 'error', 'message' => 'Pet não encontrado'];
        }

        $validatedData = Validator::make($data, [
            'nome' => 'sometimes|required|string|max:255',
            'datanasc' => 'sometimes|required|date',
            'sexo' => 'sometimes|required|string|max:1',
            'peso' => 'sometimes|required|numeric',
            'porte' => 'sometimes|required|string|max:50',
            'altura' => 'sometimes|required|numeric',
            'idusuario' => 'sometimes|required|exists:usuarios,idusuario'
        ])->validated();

        if ($pet->update($validatedData)) {
            return ['status' => 'success', 'message' => 'Pet atualizado com sucesso'];
        }

        return ['status' => 'error', 'message' => 'Erro ao atualizar o pet'];
    }

    public function getPetsByUser($userId)
    {
        return Pets::where('idusuario', $userId)->get();
    }
}
