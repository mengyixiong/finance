<?php

namespace App\Exceptions;

use App\Constant\RetConstant;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        # 配置未捕获异常的返回
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                dd($e);
                // 对于 API 请求，你可以返回自定义的 JSON 响应
                return erred(RetConstant::FAIL, __R__(RetConstant::SERVER_CRASH));
            }
        });
    }
}
