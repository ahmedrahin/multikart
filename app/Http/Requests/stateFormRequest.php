<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class stateFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'       =>  'required|unique:states,name',
            'country_id' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required'          => 'The state name field is required.',
            'name.unique'            => 'The state name has already been taken.',
            'country_id.required'    => 'Please select a country'
        ];
    }

    public function attributes(){
        return [
            'name'  => 'State',
        ];
    }

}
