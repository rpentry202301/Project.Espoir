<?php

namespace App\Http\Requests\Mypage\Profile;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:1', 'max:30'],
            'email' => ['required', 'string', 'email', 'min:6', 'max:254', 'unique:users'],
            // 半角ハイフンなし文字数制限
            'zipcode' => ['required', 'string', 'min:1', 'max:30'],
            // 半角ハイフンなし文字数制限（マンション名とかもあるしなー）
            'address' => ['required', 'string', 'min:1', 'max:30'],
            // 半角ハイフンなし文字数制限
            'telephone' => ['required', 'string', 'min:1', 'max:30'],
        ];
    }
}
