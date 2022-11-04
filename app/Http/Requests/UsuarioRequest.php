<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'cpf' => 'required|cpf',
            'rg' => 'nullable',
            'grupo' => 'required|max:1',
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
          'required' => 'O :attribute campo é necessário.'
        ];
    }
}
