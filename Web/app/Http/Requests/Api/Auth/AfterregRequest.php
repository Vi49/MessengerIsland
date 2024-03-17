<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AfterregRequest extends FormRequest
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
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|dimensions:min_width=180,min_height=180,max_width=2048,max_height=2048|max:2048',
            'first_name' => ['required', 'string', 'min:1', 'max:25'],
            'last_name' => ['string', 'min:1', 'max:25'],
        ];
    }
}
