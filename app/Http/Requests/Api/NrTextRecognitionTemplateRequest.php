<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/7/13
 * Time: 下午5:10
 */

namespace App\Http\Requests\Api;


use Dingo\Api\Http\FormRequest;

/**
 * 参数请求
 *
 * @property int $page 页码
 * @property int $per_page 条数
 * @property int template_id 模版id
 * @property string $last_launch_time 最近发布时间
 * @property string $last_update_time 最近修改时间
 */

class NrTextRecognitionTemplateRequest extends FormRequest
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
            'page' => 'sometimes|required|integer',
            'per_page' => 'sometimes|required|integer'
        ];
    }

    public function messages()
    {
        return [
        'page.required' => '页码必须',
            'page.integer' => '页码必须为整数',
            'per_page.required' => '条数必须',
            'per_page.integer' => '条数必须为整数',
        ];
    }
}