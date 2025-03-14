<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PictureRequest extends FormRequest
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
        // Edit action
        if ($this->_method == 'PUT') {
            return [
                'name' => 'bail|required|alpha_dash:ascii|max:100',
                'file' => 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }

        // Add action
        return [
            'name' => 'bail|required|alpha_dash:ascii|max:100',
            'file' => 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
