<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoCrearGrupoFormRequest extends FormRequest
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
            "nombre" => "required|max:100",
            "descripcion" => "nullable|string|max:1000",
            "precio_minimo" => "nullable|integer|min:0",
            "precio_maximo" => "nullable|integer|min:0",
            "tematica_regalos" => "nullable|string|max:50",
            "fecha_autoasignacion" => "nullable"
        ];
    }

    public function messages()
    {
        return [
            "nombre.required" => "Debes especificar un nombre para tu grupo",
            "nombre.max" => "El nombre es muy largo",
            "descripcion.string" => "La descripción no es válida ¿contiene caracteres extraños?",
            "descripcion.max" => "La descripción es muy larga",
            "precio_minimo.integer" => "El precio mínimo tiene que ser un número sin decimales",
            "precio_minimo.min" => "El precio mínimo no puede ser negativo",
            "precio_maximo.integer" => "El precio máximo debe ser un número sin decimales",
            "precio_maximo.min" => "El precio máximo no puede ser negativo",
            "tematica_regalos.string" => "La temática de los regalos no es válida ¿contiene caracteres extraños?",
            "tematica_regalos.max" => "La temática de los regalos es demasiado larga",
        ];
    }
}
