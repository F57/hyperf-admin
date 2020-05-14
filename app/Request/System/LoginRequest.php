<?php

declare(strict_types=1);

namespace App\Request\System;

use Hyperf\Validation\Request\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' =>'required|email|max:60',
            'passwd' =>'required|max:60',
            'captcha'=>'required|max:60',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' =>'邮箱',
            'passwd' =>'密码',
            'captcha'=>'验证码',
        ];
    }
}
