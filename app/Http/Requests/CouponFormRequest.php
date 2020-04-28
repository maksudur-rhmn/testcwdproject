<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponFormRequest extends FormRequest
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
           'coupon_name' => 'required|max:20|unique:coupons',
           'coupon_discount'  => 'required|numeric|min:1|max:99',
           'valid_till'       => 'required',
        ];
    }
    public function messages()
    {
        return [
           'coupon_name.unique' => 'Coupon Already Exist',
           'coupon_discount.max:99'  => 'Discount Cannot be 100%',
        ];
    }
}
