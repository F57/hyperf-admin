<?php

declare(strict_types=1);

namespace App\Request\System;

use Hyperf\Validation\Request\FormRequest;

class AdminRequest extends FormRequest
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
            'name' =>'required|max:60',
            'passwd' =>'required|max:60',
            'access'=>'required|integer|min:0',
            'role'=>'required|integer|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' =>'邮箱',
            'name' =>'昵称',
            'passwd'=>'密码',
            'access'=>'状态',
            'role'=>'角色',
        ];
    }
}
