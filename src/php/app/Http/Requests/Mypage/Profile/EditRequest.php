<?php

namespace App\Http\Requests\Mypage\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        return [
            'name' => ['required', 'string', 'min:1', 'max:30'],
            'email' => [
                'required',
                'string',
                'email',
                'min:6',
                'max:254',
                Rule::unique('users')->ignore($user->id)
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
        ];
    }
}
