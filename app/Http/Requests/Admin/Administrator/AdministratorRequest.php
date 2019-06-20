<?php

namespace App\Http\Requests\Admin\Administrator;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AdministratorRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $id = $this->route('administrator');
        // 包含regex使用数组
        return [
            'nickname' => ['required', 'regex:/^[_\w\d\x{4e00}-\x{9fa5}]{2,20}$/iu'],
            'phone' => ['required', 'regex:/^1[3-9][0-9]{9}$/', 'unique:administrators,phone,' . $id],
            'email' => 'required|unique:administrators,email,'. $id . '|email',
            'password' => !is_null($id) ? 'nullable|min:6|max:20' : 'required|min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'nickname.required' => '昵称不能为空',
            'nickname.regex' => '昵称不能含有特殊字符',
            'phone.required' => '手机不能为空',
            'phone.regex' => '手机格式错误',
            'phone.unique' => '手机号已被注册',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱已被注册',
            'email.email' => '邮箱格式错误',
            'password.required' => '密码不能为空',
            'password.min' => '密码最少6个字符',
            'password.max' => '密码最多20个字符',
        ];
    }

    /**
     * 重写父类错误返回数据，ajax请求返回合理的json数据
     * @param Validator $validator
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        if ($this->ajax() || $this->wantsJson()) {
            throw new HttpResponseException(response()->json(['code' => 422, 'msg' => $validator->errors()->first()], 422));
        } else {
            parent::failedValidation($validator);
        }
    }
}
