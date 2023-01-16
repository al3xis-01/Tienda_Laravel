<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tipo === 'ADMIN';

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
        $this->validate(
            [
                'nombre'=>'required',
                'apellido'=>'required',
                'email'=>'required',
                'username'=>'required',
                'password'=>'required',
                'tipo'  => 'required'
            ]
        );
    }
}
