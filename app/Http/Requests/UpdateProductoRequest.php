<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('productos', 'codigo')->ignore($this->route('producto')),
            ],
            'nombre' => ['sometimes', 'required', 'string', 'max:150'],
            'precio_venta' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock_minimo' => ['sometimes', 'required', 'integer', 'min:0'],
            'categoria_id' => ['sometimes', 'required', 'exists:categorias,id'],
        ];
    }
}
