<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'type'        => 'required|in:marketing,invoices,system',
            'short_text'  => 'required|string|max:255',
            'expiration'  => 'required|date|after:now',
            'destination' => 'required|in:all,specific',
            'user_id'     => 'nullable|required_if:destination,specific|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'        => 'The notification type is required.',
            'short_text.required'  => 'The short text field is required.',
            'expiration.after'     => 'The expiration date must be in the future.',
            'destination.required' => 'Please choose a destination.',
            'user_id.required_if'  => 'You must select a user if destination is specific.',
        ];
    }
}
