<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
//use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFollowUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $followUp = $this->route('followUp');
        $user     = auth()->user();
 
        if ($followUp->isCompleted()) {
            return false;
        }
 
        if ($user->isSalesStaff()) {
            return $followUp->user_id === $user->id;
        }

        return true;
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

    public function failedAuthorization()
    {
        $followUp = $this->route('followUp');
 
        if ($followUp->isCompleted()) {
            throw \Illuminate\Auth\Access\AuthorizationException::withResponse(
                back()->with('error', 'Completed follow-ups cannot be edited.')
            );
        }
 
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'You are not authorized to edit this follow-up.'
        );
    }
}
