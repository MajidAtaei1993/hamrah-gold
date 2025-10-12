<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Always authorize request
     */
    public function authorize(): bool
    {
        return true;
    }

    // form validator
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation Required',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            // 'user_id' => ['required', 'string', Rule::exists(User::class, 'id')],
            'type' => ['required', 'string', 'in:buy,sell'],
            'weight' => ['required', 'numeric', 'min:0.1'],
            'price' => ['required', 'numeric', 'min:0.1'],
            'fee' => ['required', 'numeric', 'min:0']
        ];
    }

    /**
     * Validation messages
     */
    public function messages(): array
    {
        return [
            // user_id
            'user_id.required' => 'Please provide a user ID.',
            'user_id.string' => 'User ID must be a string.',
            'user_id.exists' => 'The selected user does not exist.',

            // type
            'type.required' => 'Please specify the transaction type.',
            'type.string' => 'Transaction type must be a string.',
            'type.in' => 'Transaction type must be either buy or sell.',

            // weight
            'weight.required' => 'Please provide the weight.',
            'weight.numeric' => 'Weight must be numeric.',
            'weight.min' => 'Weight must be at least 0.1.',

            // price
            'price.required' => 'Please provide the price.',
            'price.numeric' => 'Price must be numeric.',
            'price.min' => 'Price must be at least 0.1.',

            // fee
            'fee.required' => 'Please provide the fee.',
            'fee.numeric' => 'Fee must be numeric.',
            'fee.min' => 'Fee cannot be negative.'
        ];
    }
}
