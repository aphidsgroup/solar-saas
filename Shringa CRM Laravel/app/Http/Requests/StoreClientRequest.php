<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Use policy to check authorization
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'company_name' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:15',
            'client_type' => 'required|string|in:Residential,Commercial,Office,Other',
            'notes' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Client name is required',
            'phone.required' => 'Phone number is required',
            'client_type.required' => 'Client type is required',
            'client_type.in' => 'Client type must be Residential, Commercial, Office, or Other',
            'gst_number.max' => 'GST number should not exceed 15 characters',
        ];
    }
}
