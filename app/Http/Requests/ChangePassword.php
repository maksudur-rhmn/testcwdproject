<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
           'old_password' => 'required',
           'password'     => 'required|confirmed|min:8'
        ];
    }
    public function  messages()
    {
        return [
           'old_password' => 'Old Password dao age',
           'password.required'     => 'New Password dao',
           'password.min:8'     => '8 character',
        ];
    }
}
