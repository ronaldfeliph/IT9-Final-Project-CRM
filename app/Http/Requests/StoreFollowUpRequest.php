<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
//use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFollowUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'lead_id' => 'nullable|exists:leads,id',
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,completed'
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if (empty($this->customer_id) && empty($this->lead_id)) {
                $validator->errors()->add(
                    'customer_id',
                    'Follow-up must be linked to a customer or a lead.'
                );
            }
        });
    }

    public function prepareForValidation(): void
    {
        if (empty($this->user_id)) {
            $this->merge(['user_id' => auth()->id()]);
        }
    }
}
