<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/7/14
 * Time: 上午10:56
 */

namespace App\Http\Repository\Api;


use App\Http\Models\NrRegionField;
use App\Http\Models\NrRegionRecognition;
use App\Http\Models\NrTextRecognitionTemplate;
use App\Http\Requests\Api\NrTextRecognitionTemplateRequest;
use Nexmo\Message\Query;

class TemplateManagerRepository
{
    private $_nrTextRecognitionTemplate;
    private $_nrRegionField;
    private $_nrRegionRecognition;

    /**
     * 模版模型
     * @author 刘富胜
     * @create_time 2019-7-13
     */
    public function __construct(
        NrTextRecognitionTemplate $nrTextRecognitionTemplate,
        NrRegionField $nrRegionField,
        NrRegionRecognition $nrRegionRecognition
    )
    {
        $this->_nrRegionField = $nrRegionField;
        $this->_nrRegionRecognition = $nrRegionRecognition;
        $this->_nrTextRecognitionTemplate = $nrTextRecognitionTemplate;
    }

    /**
     * 获取模型列表
     * @author 刘富胜
     * @create_time 2019-7-13
     * @param NrTextRecognitionTemplateRequest $params 参数
     * @return mixed
     */
    public function getTemplateList($params)
    {
        $page = $params->page ?? 1;
        $limit = $params->per_page ?? 10;
        $where = [
            ['is_delete', '=', 0]
        ];
        if (!empty($params->template_id)) {
            $where[] = ['id', '=', $params->template_id];
        }
        $query = $this->_nrTextRecognitionTemplate::query()
            ->select([
                'id as template_id',//模版id
                'last_update_time',//最近一次更新时间
                'img_json',//图片json数据
                'last_launch_time',//最近一次发布时间
                'state',//状态
                'version'//版本
            ])->where($where);

        if (!empty($params->last_launch_time)) {
            $query->whereRaw('left(last_launch_time,10) = ?', [$params->last_launch_time]);
        }

        if (!empty($params->last_update_time)) {
            $query->whereRaw('left(last_update_time,10) = ?', [$params->last_update_time]);
        }
        $data = $query
            ->limit($limit)
            ->paginate($page)
            ->items();

        return $data;
    }

    /**
     * 获取模型总条数
     * @author 刘富胜
     * @create_time 2019-7-13
     * @param NrTextRecognitionTemplateRequest $params 参数
     * @return int
     */
    public function getTemplateCount($params)
    {
        $where = [
            ['is_delete', '=', 0]
        ];
        if (!empty($params->template_id)) {
            $where[] = ['id', '=', $params->template_id];
        }
        $query = $this->_nrTextRecognitionTemplate::query()->where($where);

        if (!empty($params->last_launch_time)) {
            $query->whereRaw('left(last_launch_time,10) = ?', [$params->last_launch_time]);
        }

        if (!empty($params->last_update_time)) {
            $query->whereRaw('left(last_update_time,10) = ?', [$params->last_update_time]);
        }
        $count = $query->count();

        return $count;
    }


}