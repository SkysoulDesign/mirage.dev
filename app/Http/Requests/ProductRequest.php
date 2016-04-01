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
            'name'        => 'required',
            'image'       => 'mimes:png|image',
            'code'        => 'required|size:5|unique:products' . $update,
            'poster'      => 'image',
            'description' => 'required',
        ];

//        dd($this->method());

//        dd($this->all());

//        return [
//            'name'        => 'required',
//            'code'        => 'required|size:5|unique:products,id,' . $this->product()->id,
//            'image'       => 'required|mimes:jpeg,png|image',
//            'poster'      => 'required|mimes:jpeg,png|image',
//            'description' => 'required',
//        ];
    }
}
