<?php

namespace App\Http\Requests;

use App\Models\Integrante;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExclusionRequest extends FormRequest
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
        $idParticipanteQueRegala = $this->grupo->integrantesDelGrupo()->where("usuario", auth()->user()->id)->first()->id;

        return [
            "usuario_excluido" => [
                "required",
                "exists:integrantes,id",
                Rule::unique("exclusiones", "usuario_excluido")->where("usuario_que_regala", $idParticipanteQueRegala)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            "usuario_excluido.required" => "Debes especificar el usuario que quieres excluir",
            "usuario_excluido.exists" => "El usuario que quieres excluir no existe",
            "usuario_excluido.unique" => "El usuario que pretendes excluir, ya está en tu lista de excluidos"
        ];
    }
}
