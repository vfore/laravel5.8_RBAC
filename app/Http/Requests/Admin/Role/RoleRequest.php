<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RoleRequest extends FormRequest
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
        return [
            'name' => 'required',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '角色名不能为空'
        ];
    }

    /**
     * 重写父类错误返回数据，ajax请求返回合理的json数据
     * @param Validator $validator
     * @throws \Illuminate\Validation\ValidationException
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
