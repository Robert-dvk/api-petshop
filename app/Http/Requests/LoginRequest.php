<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Modifique conforme suas necessidades de autorização
    }

    public function rules()
    {
        return [
            'login' => 'required|string',
            'senha' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'login.required' => 'O campo login é obrigatório.',
            'login.string' => 'O campo login deve ser uma string.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.string' => 'O campo senha deve ser uma string.',
        ];
    }
}
