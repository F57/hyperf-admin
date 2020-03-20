<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class UserInfoRequest extends FormRequest
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
            'img'=>'required|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' =>'邮箱',
            'name' =>'昵称',
            'img'=>'头像',
        ];
    }
}
