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

        $update = ($this->product && $this->product->code === $this->get('code')) ? ',id,' . $this->product->id : '';

        return [
            'name.en'        => 'required',
            'image'       => 'mimes:png|image',
            'code'        => 'required|size:5|unique:products' . $update,
            'poster'      => 'image',
            'description.en' => 'required',
        ];

    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    /*public function messages()
    {
        return ['*.en.required' => 'english'];
    }*/

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name.en' => 'Name', 'description.en' => 'Description',
            'name.zh' => 'Chinese Name', 'description.zh' => 'Chinese Description',
            'name.zh_tw' => 'Simplified Chinese Name', 'description.zh_tw' => 'Simplified Chinese Description',
            'name.ja' => 'Japanese Name', 'description.ja' => 'Japanese Description',
        ];
    }

}
