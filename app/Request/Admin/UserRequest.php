<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class UserRequest extends FormRequest
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
            'email' =>'required|email|max:255',
            'name' =>'required|max:255',
            'passwd' =>'required|max:255',
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
