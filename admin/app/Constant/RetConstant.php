<?php

namespace App\Constant;

class RetConstant
{
    # 返回代码
    const OK = 20000;
    const FAIL = 50000;
    const LOGIN_FAIL = 50001;
    const FIELD_VALIDATION_FAIL = 50002;
    const ILLEGAL_TOKEN = 50008;
    const OTHER_CLIENTS_LOGGED_IN = 50012;
    const TOKEN_EXPIRED = 50014;
    const USER_NOT_FOUND = 50015;
    const USER_ADD_FAIL = 50016;

    # 返回文字
    const USER_ADD_SUCCESS = 'user_add_success';
    const SERVER_CRASH = 'server_crash';

}
