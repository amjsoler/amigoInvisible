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
        ];
    }
}
