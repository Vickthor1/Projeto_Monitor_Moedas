<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaMoedaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'moeda_origem' => ['required', 'string', 'size:3'],
            'moeda_destino' => ['required', 'string', 'size:3'],
            'valor' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'moeda_origem.required' => 'A moeda de origem é obrigatória.',
            'moeda_destino.required' => 'A moeda de destino é obrigatória.',
            'valor.required' => 'Informe um valor para conversão.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor deve ser maior que zero.',
        ];
    }
}
