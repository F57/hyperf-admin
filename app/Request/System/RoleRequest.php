<?php

declare(strict_types=1);

namespace App\Request\System;

use Hyperf\Validation\Request\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|max:60',
            'description' => 'max:60',
            'guard_name' => 'max:60',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '角色名称',
            'description' => '说明',
            'guard_name' => '认证类型',
        ];
    }
}
