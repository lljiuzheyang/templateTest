<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/7/13
 * Time: 下午6:01
 */

namespace App\Http\Service\Api;


use App\Http\Helper\ResultHelper;
use App\Http\Repository\Api\TemplateManagerRepository;
use App\Http\Requests\Api\NrTextRecognitionTemplateRequest;

class TemplateManagerService
{
    private $_templateManagerRepository;

    /**
     * 模版业务
     * @author 刘富胜
     * @create_time 2019-7-13
     */
    public function __construct(
        TemplateManagerRepository $templateManagerRepository
    )
    {
        $this->_templateManagerRepository = $templateManagerRepository;
    }

    /**
     * 获取模版列表
     * @author 刘富胜
     * @create_time 2019-7-13
     * @param NrTextRecognitionTemplateRequest $params 参数
     * @return mixed
     */
    public function getTemplateList($params)
    {
        //获取模版列表数据
        $count = $this->_templateManagerRepository->getTemplateCount($params);
        $items = $this->_templateManagerRepository->getTemplateList($params);

        return ResultHelper::generate(ResultHelper::SUCCESS_CODE,'',
            ['items'=>$items,'count'=>$count],true);
    }

}