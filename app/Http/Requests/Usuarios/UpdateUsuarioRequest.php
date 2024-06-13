<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['sometimes', 'string', 'max:255'],
            'telefone' => ['sometimes', 'string'],
            'login' => ['sometimes', 'string', 'max:255'],
            'senha' => ['sometimes', 'string', 'min:8'],
            'isadmin' => ['sometimes', 'boolean']
        ];
    }


    public function messages()
    {
        return [
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',

            'telefone.string' => 'O campo telefone deve ser uma string.',

            'login.string' => 'O campo login deve ser uma string.',
            'login.max' => 'O campo login não pode ter mais que 255 caracteres.',

            'senha.string' => 'O campo senha deve ser uma string.',
            'senha.min' => 'O campo senha deve ter pelo menos 8 caracteres.',

            'isadmin.boolean' => 'O campo isAdmin deve ser verdadeiro ou falso.',
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
