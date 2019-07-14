<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Exceptions;

use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\ValidationHttpException;
use Doctrine\DBAL\Driver\PDOException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     */
    public function report(Exception $exception)
    {
        if (!app()->isLocal() && !isset($GLOBALS['error_handle'])) {
//            logError($exception);
            $GLOBALS['error_handle'] = 1;
            // 验证规则不通过
            if ($exception instanceof ValidationException) {
                throw new ResourceException(current($exception->errors())[0], $exception->errors());
            }
            // 验证规则不通过
            if ($exception instanceof ValidationHttpException) {
                throw new ResourceException($exception->getErrors()->first(), $exception->getErrors());
            }
            if ($exception instanceof ResourceException) {
                throw new ResourceException($exception->getErrors()->first(), $exception->getErrors());
            }
            if ($exception instanceof UnauthorizedException) {
                throw new HttpException(403, '权限不足');
            }
            // 授权失败
            if ($exception instanceof UnauthorizedHttpException) {
                throw new HttpException(401, 'token已过期');
            }
            // 请求路由不存在
            if ($exception instanceof MethodNotAllowedHttpException) {
                throw new HttpException(500, '非法操作');
            }
            // 查询数据不存在
            if ($exception instanceof ModelNotFoundException) {
                throw new HttpException(500, '非法操作');
            }
            // 捕获其它错误
            if ($exception instanceof HttpException) {
                if (preg_match("/[\x80-\xff]/", $exception->getMessage())) {
                    throw new HttpException($this->getErrorCode($exception), $exception->getMessage());
                }
                throw new HttpException(500, '非法操作');
            }
            // 数据库连接失败
            if ($exception instanceof PDOException) {
                throw new HttpException(500, '数据库连接失败');
            }
            if ($exception instanceof Exception) {
                if (preg_match("/[\x80-\xff]/", $exception->getMessage())) {
                    throw new HttpException($this->getErrorCode($exception), $exception->getMessage());
                }
                throw new HttpException(500, '非法操作');
            }
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
