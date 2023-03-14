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
            // 'name' => ['required', 'string', 'min:1', 'max:30'],
            // 'email' => ['required', 'string', 'email', 'min:6', 'max:254', 'unique:users'],
            // 'zipcode' => ['required', 'numeric', 'digits:7'],
            // 'address' => ['required', 'string', 'min:1', 'max:30'],
            // 'telephone' => ['required', 'numeric', 'digits_between:10,14'],
        ];
    }


    // public function withValidator(Validator $validator)
    // {
    //     $validator->sometimes('required', 'string', 'email', 'min:6', 'max:254', function ($email) {
    //         return $email == Auth::user()->email;
    //     });
    // }

    public function attributes()
    {
        return [
            // 'name' => 'ユーザー名',
            // 'email' => 'メールアドレス',
            // 'zipcode' => '郵便番号',
            // 'address' => '住所',
            // 'telephone' => '電話番号',
        ];
    }
}
