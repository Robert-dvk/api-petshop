<?php
namespace App\Http\Requests\Agenda;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAgendaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'idpet' => 'required|exists:pets,idpet',
            'idusuario' => 'required|exists:usuarios,idusuario'
        ];
    }

    public function messages()
    {
        return [
            'data.required' => 'O campo data é obrigatório.',
            'data.date' => 'O campo data deve ser uma data válida.',
            'hora.required' => 'O campo hora é obrigatório.',
            'hora.date_format' => 'O campo hora deve estar no formato HH:mm.',
            'idpet.required' => 'O campo ID do pet é obrigatório.',
            'idpet.exists' => 'O pet selecionado não existe.',
            'idusuario.required' => 'O campo ID do usuário é obrigatório.',
            'idusuario.exists' => 'O usuário selecionado não existe.'
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
