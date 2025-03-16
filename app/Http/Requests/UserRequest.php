<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    private $table = 'users';
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
        // Edit action
        if ($this->isMethod('PUT')) {
            return [
                // validate unique username, except the current user
                // unique:table,column,exceptID
                'username' => "bail|required|unique:$this->table,username,$this->id|between:5,25",
                'password' => 'bail|nullable|between:5,25|confirmed',
                'current_password' => 'nullable|required_with:password'
            ];
        }

        // Add action
        return [
            'username' => "bail|required|unique:$this->table,username|between:5,25",
            'password' => 'bail|required|between:5,25|confirmed',
        ];
    }
}
