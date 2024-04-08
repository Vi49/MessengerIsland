<?php

namespace App\Http\Requests\Api\Messages;

use Illuminate\Foundation\Http\FormRequest;

class SendTextMessageRequest extends FormRequest
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
            'second_user_id' => 'required|numeric',
            'content' => 'required|string|min:1|max:500',
            'encryption' => 'string|min:1|max:64'
        ];
    }
}
