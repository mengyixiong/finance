<?php

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Constant\RetConstant;

/**
 * 成功json响应
 * @param $data
 * @param string $message
 * @param int $code
 * @return JsonResponse
 */
function succeed($data = null, string $message = '操作成功', int $code = RetConstant::OK): JsonResponse
{
    return response()->json([
        'code' => $code,
        'message' => $message,
        'data' => $data,
    ]);
}

/**
 * 失败json响应
 * @param $code
 * @param $message
 * @param $data
 * @return JsonResponse
 */
function erred($code = RetConstant::FAIL, $message = '', $data = null): JsonResponse
{
    $message = $message ?: __R__($code);

    return response()->json([
        'code' => $code,
        'message' => $message,
        'data' => $data,
    ]);
}

/**
 * RetConstant响应获取文本
 */
function __R__($code)
{
    $codeMap = require_once base_path('language/' . env('APP_LANGUAGE','zh_cn') . '/ret.php');
    return $codeMap[$code] ?? '操作失败';
}

/**
 * 将map映射设置成 label => value , value => key
 */
function map2Options(array $map)
{
    $options = [];
    foreach ($map as $key => $value) {
        $options[] = [
            'label' => $value,
            'value' => $key,
        ];
    }
    return $options;
}
