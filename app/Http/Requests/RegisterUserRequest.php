<?php

namespace App\Http\Requests;

/**
 * Class RegisterUserRequest
 * @package App\Http\Requests
 */
class RegisterUserRequest extends Request
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
            'username' => 'required|alpha_dash|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'gender' => 'string',
            'age_id' => 'exists:ages,id',
            'terms' => 'required|accepted',
            'country_id' => 'required|exists:countries,id',
        ];
    }
}
