<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\NrTextRecognitionTemplateRequest;
use App\Http\Service\Api\TemplateManagerService;

class TemplateManagerController extends BaseController
{
    private $_templateManagerService;

    public function __construct(TemplateManagerService $templateManagerService)
    {
        $this->_templateManagerService = $templateManagerService;
    }

    /**
     * 模型模版列表.
     *
     * @author 刘富胜
     *
     * @version v1.0.0
     *
     * @param NrTextRecognitionTemplateRequest $request
     */
    public function list(NrTextRecognitionTemplateRequest $request)
    {
        return $this->_templateManagerService->getTemplateList($request);
    }
}
