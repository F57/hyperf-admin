<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class PwdRequest extends FormRequest
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
            'password' => 'required|max:60|confirmed',
            'password_confirmation' => 'required|max:60',
        ];
    }

	public function attributes(): array
	{
		return [
			'password' =>'密码',
			'password_confirmation' =>'密码',
		];
	}
}
