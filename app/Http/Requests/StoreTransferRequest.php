<?php

namespace App\Http\Requests;

use App\Enums\TransactionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1'],
            'account' => ['required', 'exists:users,account'],
            'agency' => ['required', 'exists:users,agency'],
            'type' => ['required', Rule::enum(TransactionTypes::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'A quantia é obrigatória.',
            'amount.numeric' => 'A quantia deve ser um número.',
            'amount.min' => 'A quantia deve ser maior ou igual a R$ :min,00.',
            'account.required' => 'A conta de destino é obrigatória.',
            'account.exists' => 'A conta de destino não existe.',
            'agency.required' => 'A agencia de destino é obrigatória.',
            'agency.exists' => 'A agencia de destino não existe.',
        ];
    }
}
