<?php

namespace App\Http\Requests\Mypage\Profile;

use Illuminate\Foundation\Http\FormRequest;

class DestinationEditRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'zipcode' => ['required', 'numeric', 'digits:7'],
            'address' => ['required', 'string', 'min:1', 'max:30'],
            'telephone' => ['required', 'numeric', 'digits_between:10,14']
        ];
    }

    public function attributes()
    {
        return [
            'zipcode' => '郵便番号',
            'address' => '住所',
            'telephone' => '電話番号'
        ];
    }
}
