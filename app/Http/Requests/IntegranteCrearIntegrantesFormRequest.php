<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntegranteCrearIntegrantesFormRequest extends FormRequest
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
            "integrantes" => "required|array",
            "integrantes.*.nombre" => "required|string|max:100",
            "integrantes.*.correo" => "required|email|unique:integrantes,correo"
        ];
    }
}
