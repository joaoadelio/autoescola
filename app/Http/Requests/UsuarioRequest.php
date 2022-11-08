<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        switch ( $this->method() ) {
            case 'POST':
                return [
                    'name' => 'required',
                    'cpf' => 'required|unique:users',
                    'rg' => 'nullable',
                    'grupo' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
                    'categoria_habilitacao' => 'required',
                ];
                break;
            case 'PATCH':
            case 'PUT':
                $user = $this->user();

                return [
                    'name' => 'required',
                    'cpf' => ['required', Rule::unique('users', 'id')->ignore($user->id)],
                    'rg' => 'nullable',
                    'grupo' => 'required',
                    'email' => ['required', Rule::unique('users', 'id')->ignore($user->id)],
                    'categoria_habilitacao' => 'required',
                ];
                break;
        }
    }

    /**
     * Return message for rules applied
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é necessário.',
            'cpf' => ':attribute já cadastrado',
            'email' => ':attribute já cadastrado',
            'unique' => ':attribute já cadastrado'
        ];
    }
}
