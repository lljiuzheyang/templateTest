<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Service\Api;

use App\Http\Enums\CodeEnum;
use App\Http\Repository\Api\TemplateManagerRepository;
use App\Http\Requests\Api\NrTextRecognitionTemplateRequest;
use App\Http\Service\BaseService;

class TemplateManagerService extends BaseService
{
    private $_templateManagerRepository;

    /**
     * 模版业务
     *
     * @author      刘富胜
     * @create_time 2019-7-13
     * TemplateManagerService constructor.
     *
     * @param TemplateManagerRepository $templateManagerRepository
     */
    public function __construct(
        TemplateManagerRepository $templateManagerRepository
    ) {
        parent::__construct();
        $this->_templateManagerRepository = $templateManagerRepository;
    }

    /**
     * 获取模版列表.
     *
     * @author      刘富胜
     * @create_time 2019-7-13
     *
     * @param NrTextRecognitionTemplateRequest $params 参数
     *
     * @return mixed
     */
    public function getTemplateList($params)
    {
        //获取模版列表数据
        // 参数尽量在控制器读取
        $count = $this->_templateManagerRepository->getTemplateCount($params);
        $items = $this->_templateManagerRepository->getTemplateList($params);

        $data = [
            'items' => $items,
            'count' => $count,
        ];

        return $this->result(CodeEnum::SUCCESS, $data);
    }
}
