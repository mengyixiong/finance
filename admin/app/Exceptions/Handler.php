<?php

namespace App\Exceptions;

use App\Constant\RetConstant;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        # 配置未捕获异常的日志记录
        $this->reportable(function (Throwable $e) {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        });

        /**
         * MethodNotAllowedHttpException 是在 HTTP 请求方法不被允许时抛出的异常，例如，当客户端对某个路由使用了不支持的 HTTP 方法时。
         * 这种异常通常在路由层面就被捕获并处理，所以它可能不会到达 reportable 方法。
         */
        $this->renderable(function (MethodNotAllowedHttpException|RouteNotFoundException $e, $request) {
            if ($request->is('api/*')) {

                // 对于 API 请求，你可以返回自定义的 JSON 响应
                return erred(RetConstant::ROUTE_NOT_FOUND);
            }
        });

        # 配置未捕获异常的返回
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {

                // 对于 API 请求，你可以返回自定义的 JSON 响应
                return erred(RetConstant::FAIL, __R__(RetConstant::SERVER_CRASH));
            }
        });
    }
}
