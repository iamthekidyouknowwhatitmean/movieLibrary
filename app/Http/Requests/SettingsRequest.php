<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingsRequest extends FormRequest
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
            'first_name' => 'sometimes|string|max:50',
            'last_name'  => 'sometimes|string|max:50',
            'location'   => 'sometimes|string|max:100',
            'website'    => 'sometimes|nullable|url|max:255',
            'bio'        => 'sometimes|nullable|string|max:500',
            'email'      => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
        ];
    }
}
