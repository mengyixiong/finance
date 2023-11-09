<?php

namespace App\Http\Controllers\auth;

use App\Constant\RetConstant;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * 登录
     * @throws ApiException
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        # 登录
        if (!$token = Auth::attempt($credentials)) {
            throw new ApiException(RetConstant::LOGIN_FAIL);
        }

        # 更新登录时间和登录IP
        auth()->user()->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        return succeed([
            'token' => $token
        ]);
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        auth()->logout();
        return succeed();
    }

    public function info()
    {
        return succeed(Auth::user());
    }
}
