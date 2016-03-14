<?php

namespace App\Http\Requests;

class ProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'code'        => 'required|size:5|unique:products',
            'image'       => 'required|mimes:jpeg,png|image',
            'poster'      => 'required|mimes:jpeg,png|image',
            'description' => 'required',
        ];
    }
}
