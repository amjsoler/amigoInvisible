<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IntegranteCrearIntegranteFormRequest extends FormRequest
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
            "nombre" => "required|string|max:100",
            "correo" => [
                "required",
                "email",
                Rule::unique("integrantes", "correo")->where("grupo", $this->grupo->id)
            ]
        ];
    }

    public function messages()
    {
        return [
            "nombre.required" => "Debes especificar el nombre con el que participas",
            "nombre.string" => "El nombre debe ser una cadena válida ¿Contiene algún carácter extraño?",
            "nombre.max" => "El nombre es muy largo",
            "correo.required" => "Debes especificar un correo para enviarte la confirmación",
            "correo.email" => "El correo no tiene un formato correcto",
            "correo.unique" => "El correo ya está inscrito en este grupo. Habla con el administrador"
        ];
    }
}
