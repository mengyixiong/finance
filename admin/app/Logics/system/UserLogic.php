<?php

namespace App\Logics\system;

use App\Constant\ConfigConstant;
use App\Constant\RetConstant;
use App\Exceptions\ApiException;
use App\Http\Requests\system\StoreUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserLogic
{
    /**
     * 获取分页数据
     */
    public function getList()
    {
        $limit = request()->input('limit', 15);
        $query = User::query();

        # 关键词
        if (request()->has('keyword')) {
            $query->where(function (Builder $query) {
                $query
                    ->where('nickname', 'like', '%' . request()->keyword . '%')
                    ->orWhere('username', 'like', '%' . request()->keyword . '%');
            });
        }

        # 冻结
        if (request()->filled('is_freeze')) {
            $query->where('is_freeze', request()->is_freeze);
        }

        $query->orderBy('created_at', 'DESC');
        return $query->paginate($limit);
    }


    /**
     * 添加用户
     * @throws ApiException
     */
    public function addUser(StoreUserRequest $request)
    {

        # 获取验证后的数据
        $data = $request->validated();

        # 设置初始密码
        $data['password'] = Hash::make("123456");
        $data['avatar'] = $request->avatar ?? ConfigConstant::DEFAULT_AVATAR;

        # 添加
        $user = User::create($data);

        if (empty($user)) {
            throw new ApiException(RetConstant::USER_ADD_FAIL);
        }

        return $user;
    }

    public function resetPassword()
    {
        # 判断上
        $validator = Validator::make(request()->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:16',
        ], [
            'old_password.required' => '旧密码不能为空',
            'new_password.required' => '新密码不能为空',
            'new_password.min' => '密码在6-16个字符之间',
            'new_password.max' => '密码在6-16个字符之间',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            throw new ApiException(RetConstant::FAIL, $validator->errors()->first());
        }

        # 获取验证后的数据
        $data = $validator->validated();

        return auth()->user();
        # 更新登录时间和登录IP
        auth()->user()->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

    }

}
