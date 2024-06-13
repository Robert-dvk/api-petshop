<?php
namespace App\Http\Requests\Agenda;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateServicosAgendaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'idagenda' => 'required|exists:agenda,idagenda',
            'idservico' => 'required|exists:servicos,idservico'
        ];
    }

    public function messages()
    {
        return [
            'idpeidagendat.required' => 'O campo ID da agenda é obrigatório.',
            'idagenda.exists' => 'A agenda selecionada não existe.',
            'idservico.required' => 'O campo ID do serviço é obrigatório.',
            'idservico.exists' => 'O serviço selecionado não existe.'
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
