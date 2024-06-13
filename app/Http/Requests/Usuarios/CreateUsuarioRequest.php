<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'string'],
            'login' => ['required', 'string', 'max:255', 'unique:usuarios,login'],
            'senha' => ['required', 'string', 'min:8'],
            'isadmin' => ['boolean']
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',

            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.string' => 'O campo telefone deve ser uma string.',

            'login.required' => 'O campo login é obrigatório.',
            'login.string' => 'O campo login deve ser uma string.',
            'login.max' => 'O campo login não pode ter mais que 255 caracteres.',
            'login.unique' => 'O login já está em uso.',

            'senha.required' => 'O campo senha é obrigatório.',
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
