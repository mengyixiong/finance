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
        # 上传头像
        $path = $request->file('avatar')->store(ConfigConstant::AVATAR_STORAGE_PATH);

        # 获取验证后的数据
        $data = $request->validated();

        # 设置初始密码
        $data['password'] = Hash::make("123456");
        $data['avatar'] = Storage::url($path) ?: ConfigConstant::DEFAULT_AVATAR;

        # 添加
        $user = User::create($data);

        if (empty($user)) {
            throw new ApiException(RetConstant::USER_ADD_FAIL);
        }

        return $user;
    }
}
