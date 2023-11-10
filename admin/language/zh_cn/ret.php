<?php

use App\Constant\RetConstant;

return [
    RetConstant::OK => '操作成功',
    RetConstant::FAIL => '操作失败',
    RetConstant::LOGIN_FAIL => '登录失败',
    RetConstant::ILLEGAL_TOKEN => '非法的令牌',
    RetConstant::OTHER_CLIENTS_LOGGED_IN => '其他已登录的客户端',
    RetConstant::TOKEN_EXPIRED => '令牌过期',
    RetConstant::USER_ADD_SUCCESS => '添加用户成功',
    RetConstant::SERVER_CRASH => '服务器崩溃，请联系管理员',
    RetConstant::RESET_PASSWORD_SUCCESS => '重置密码成功',
    RetConstant::ROUTE_NOT_FOUND => '访问的url不存在',
];
