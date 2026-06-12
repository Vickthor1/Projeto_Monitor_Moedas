<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaMoedaRequest extends FormRequest
{
    private const CURRENCIES = [
        'USD', 'EUR', 'GBP', 'BRL', 'JPY', 'CAD', 'AUD', 'CHF', 'CNY', 'ARS', 'MXN', 'INR', 'KRW', 'NZD', 'SGD',
    ];

    protected function prepareForValidation(): void
    {
        $this->merge([
            'moeda_origem' => strtoupper($this->input('moeda_origem', '')),
            'moeda_destino' => strtoupper($this->input('moeda_destino', '')),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'moeda_origem' => ['required', 'string', 'size:3', 'in:' . implode(',', self::CURRENCIES)],
            'moeda_destino' => ['required', 'string', 'size:3', 'in:' . implode(',', self::CURRENCIES), 'different:moeda_origem'],
            'valor' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'moeda_origem.required' => 'A moeda de origem é obrigatória.',
            'moeda_origem.in' => 'A moeda de origem deve ser um código válido.',
            'moeda_destino.required' => 'A moeda de destino é obrigatória.',
            'moeda_destino.in' => 'A moeda de destino deve ser um código válido.',
            'moeda_destino.different' => 'A moeda de destino deve ser diferente da moeda de origem.',
            'valor.required' => 'Informe um valor para conversão.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor deve ser maior que zero.',
        ];
    }
}
