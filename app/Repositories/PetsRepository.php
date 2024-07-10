<?php

namespace App\Repositories;

use App\Models\Pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PetsRepository
{
    public function all()
    {
        return Pets::all();
    }

    public function store(Request $request, $image)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'datanasc' => 'required|date',
            'sexo' => 'required|string|max:1',
            'peso' => 'required|numeric',
            'porte' => 'required|string|max:50',
            'altura' => 'required|numeric',
            'imagem' => 'nullable',
            'idusuario' => 'required|exists:usuarios,idusuario',
        ]);
        if ($image) {
            $validatedData['imagem'] = $image;
        }

        $pet = Pets::create($validatedData);

        if ($pet) {
            return response()->json(['status' => 'success', 'data' => $pet], 201);
        }

        return response()->json(['status' => 'error', 'message' => 'Erro ao cadastrar o pet'], 500);
    }

    public function delete($id)
    {
        $pet = Pets::find($id);
        if ($pet) {
            if ($pet->imagem) {
                Storage::disk('public')->delete($pet->imagem);
            }

            if ($pet->delete()) {
                return ['status' => 'success', 'message' => 'Pet excluído com sucesso'];
            }
        }

        return ['status' => 'error', 'message' => 'Erro ao excluir o pet'];
    }

    public function update($id, array $data, $image)
    {
        $pet = Pets::find($id);
        if (!$pet) {
            return ['status' => 'error', 'message' => 'Pet não encontrado'];
        }

        $validator = Validator::make($data, [
            'nome' => 'sometimes|required|string|max:255',
            'datanasc' => 'sometimes|required|date',
            'sexo' => 'sometimes|required|string|max:1',
            'peso' => 'sometimes|required|numeric',
            'porte' => 'sometimes|required|string|max:50',
            'altura' => 'sometimes|required|numeric',
            'imagem' => 'nullable',
            'idusuario' => 'sometimes|required|exists:usuarios,idusuario'
        ]);

        if ($image) {
            $validatedData['imagem'] = $image;
        }

        if ($validator->fails()) {
            return ['status' => 'error', 'message' => $validator->errors()];
        }

        $validatedData = $validator->validated();

        if (isset($data['imagem'])) {
            if ($pet->imagem) {
                Storage::disk('public')->delete($pet->imagem);
            }

            $path = $data['imagem']->store('pets', 'public');
            $validatedData['imagem'] = $path;
        }

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
