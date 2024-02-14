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

    public function messages()
    {
        return [
            "integrantes.required" => "Debes especificar una lista de integrantes",
            "integrantes.array" => "El formato de la lista de integrantes no es correcta",
            "integrantes.*.nombre.required" => "Falta el nombre de algún integrante",
            "integrantes.*.nombre.string" => "Algún nombre no tiene un formato correcto",
            "integrantes.*.nombre.max" => "Algún nombre es demasiado largo",
            "integrantes.*.correo.required" => "Falta el correo de algún integrante",
            "integrantes.*.correo.email" => "El correo de algún integrante no tiene un formato correcto",
            "integrantes.*.correo.unique" => "El correo de algún integrante está repetido"
        ];
    }
}
