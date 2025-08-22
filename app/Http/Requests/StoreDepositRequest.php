<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'A quantia é obrigatória.',
            'amount.numeric' => 'A quantia deve ser um número.',
            'amount.min' => 'A quantia deve ser maior ou igual a R$ :min,00.',
        ];
    }
}
