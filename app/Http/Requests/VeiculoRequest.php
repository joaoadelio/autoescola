<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeiculoRequest extends FormRequest
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

    public function rules(): array
    {
        switch ( $this->method() ) {
            case 'POST':
                return [
                    'descricao' => 'required',
                    'placa' => 'required|unique:veiculos',
                    'ano_modelo' => 'required|numeric|max_digits:4|min_digits:4',
                    'ano_fabricacao' => 'required|numeric|max_digits:4|min_digits:4',
                    'categoria_habilitacaos_id' => 'required',
                ];
                break;
            case 'PATCH':
            case 'PUT':
                return [
                    'descricao' => 'required',
                    'placa' => ['required', Rule::unique('veiculos', 'id')],
                    'ano_modelo' => 'required|numeric|max_digits:4|min_digits:4',
                    'ano_fabricacao' => 'required|numeric|max_digits:4|min_digits:4',
                    'categoria_habilitacaos_id' => 'required',
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
            'max_digits' => 'O campo :attribute permite :max digitos',
            'min_digits' => 'O campo :attribute precisa conter :min digitos',
            'numeric' => 'O campo :attribute permite apenas numeros',
            'unique' => ':attribute já cadastrad'
        ];
    }
}
