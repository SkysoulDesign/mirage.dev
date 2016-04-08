<?php

namespace App\Http\Requests;

class ExtraRequest extends Request
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
        $mediaRequired = @$this->extra->id ? 'sometimes' : 'required';

        return [
            'title.en'       => 'required',
            'description.en' => 'required',
            'image'       => $mediaRequired.'|mimes:png',
            'video'       => $mediaRequired.'|mimes:mp4'
        ];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title.en' => 'Title', 'description.en' => 'Description',
            'title.zh' => 'Chinese Title', 'description.zh' => 'Chinese Description',
            'title.zh_tw' => 'Simplified Chinese Title', 'description.zh_tw' => 'Simplified Chinese Description',
            'title.ja' => 'Japanese Title', 'description.ja' => 'Japanese Description',
        ];
    }
}
