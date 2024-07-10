<?php

namespace App\Http\Requests\Pets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'datanasc' => 'required|date',
            'sexo' => 'required|string|max:10',
            'peso' => 'required|numeric',
            'porte' => 'required|string|max:50',
            'altura' => 'required|numeric',
            'imagem' => 'nullable',
            'idusuario' => 'required|exists:usuarios,idusuario'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',
            'datanasc.required' => 'O campo data de nascimento é obrigatório.',
            'datanasc.date' => 'O campo data de nascimento deve ser uma data válida.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'sexo.string' => 'O campo sexo deve ser uma string.',
            'sexo.max' => 'O campo sexo não pode ter mais que 1 caractere.',
            'peso.required' => 'O campo peso é obrigatório.',
            'peso.numeric' => 'O campo peso deve ser um número.',
            'porte.required' => 'O campo porte é obrigatório.',
            'porte.string' => 'O campo porte deve ser uma string.',
            'porte.max' => 'O campo porte não pode ter mais que 50 caracteres.',
            'altura.required' => 'O campo altura é obrigatório.',
            'altura.numeric' => 'O campo altura deve ser um número.',
            'idusuario.required' => 'O campo ID do usuário é obrigatório.',
            'idusuario.exists' => 'O ID do usuário fornecido não existe.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Falha na validação dos dados enviados',
            'errors' => $validator->errors()
        ], 422));
    }
}
