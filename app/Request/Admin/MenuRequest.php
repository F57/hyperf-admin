<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class MenuRequest extends FormRequest
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
            'parent_id' => 'required|integer|min:0',
            'name' => 'required|max:60',
            'display_name' => 'max:60',
            'url' => 'required|max:60',
            'icon' => 'max:60',
            'guard_name' => 'max:60',
            'status' => 'required|in:0,1',
            'sort' =>  'required|integer|min:0',
        ];
    }

	public function attributes(): array
	{
		return [
			'parent_id' => '父级菜单',
			'name' => '权限',
			'display_name' => '说明',
			'url' => '地址',
			'icon' => '图标',
			'guard_name' => '认证类型',
			'status' => '状态',
			'sort' =>  '排序',
		];
	}
}
