<?php

namespace App\Http\Requests\system;

use App\Http\Requests\BaseRequest;

class StoreUserRequest extends BaseRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [
            'username' => 'required|min:4|max:16|unique:users,username',
            'email' => 'nullable|email',
            'nickname' => 'required|string|min:2|max:4',
            'created_by' => 'required|integer',
            'updated_by' => 'required|integer'
        ];
        if ($this->filled('id')) {
            $rules['username'] = 'required|min:4|max:16|unique:users,username,' . $this->get('id');
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空。',
            'username.unique' => '用户名已经存在。',
            'username.min' => '用户名的长度在4-16个字符之间。',
            'username.max' => '用户名的长度在4-16个字符之间。',
            'email.email' => '请填写正确的邮箱。',
            'nickname.required' => '真实姓名不能为空。',
            'nickname.min' => '真实姓名的长度在2-4个字符之间。',
            'nickname.max' => '真实姓名的长度在2-4个字符之间。',
            'created_by.required' => '创建人不能为空。',
            'created_by.integer' => '创建人不能为空。',
            'updated_by.required' => '更新人不能为空',
            'updated_by.required:id' => '在更新记录时，必须提供更新人信息。',
            'updated_by.integer' => '更新人ID必须是整数。',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
//            'created_by' => auth()->id(), // 假设用户已经登录
//            'updated_by' => auth()->id(), // 假设用户已经登录
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }

}
