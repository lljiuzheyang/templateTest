<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/7/12
 * Time: 下午2:19
 */

namespace App\Http\Requests\Api;


use Dingo\Api\Http\FormRequest;

class UserAuthRequest extends FormRequest
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
            //用户名或者email
            'username' => 'required|string|between:1,15',
            'password' => 'required|string|between:8,20',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空。',
            'username.between' => '用户名必须介于 1 - 15 个字符之间。',
            'password.required' => '密码不能为空。',
            'password.between' => '密码必须介于 8 - 20 个字符之间。',
        ];
    }

}