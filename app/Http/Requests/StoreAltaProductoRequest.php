<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAltaProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tipo ==='ADMIN';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function validar()
    {
        $this->validate([
            'motivo'=>'required',
            'id_proveedor'=>'required',
            'descuento'=>'required',
            'subtotal'=>'required',
            'total'=>'required',
        ]);
    }
}
