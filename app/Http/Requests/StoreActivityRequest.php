<?php

namespace App\Http\Requests;

use App\Models\Activity;
//use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreActivityRequest extends FormRequest
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
            'activity_type' => 'required|in:' . implode(',', array_keys(Activity::TYPES)),
            'description' => 'required|string',
            'activity_date' => 'required|date'
        ];
    }
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if (empty($this->customer_id) && empty($this->lead_id)) {
                $validator->errors()->add(
                    'customer_id',
                    'Activity must be linked to a customer or a lead.'
                );
            }
        });
    }
 
    public function prepareForValidation(): void
    {
        $this->merge(['user_id' => auth()->id()]);
    }
}
