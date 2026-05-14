<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $lead = $this->route('lead');
        $user = auth()->user();
 
        if ($user->isSalesStaff()) {
            return $lead->assigned_user_id === $user->id;
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'source' => 'nullable|string|max:255',
            'status' => 'required|in:' . implode(',', array_keys(Lead::STATUSES)),
            'priority' => 'required|in:' . implode(',', array_keys(Lead::PRIORITIES)),
            'expected_value' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'assigned_user_id' => 'nullable|exists:users,id'
        ];
    }
}
