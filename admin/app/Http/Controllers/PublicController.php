<?php

namespace App\Http\Controllers;

use App\Constant\ConfigConstant;
use App\Constant\RetConstant;
use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{

    /**
     * 上传头像
     * @throws ApiException
     */
    public function uploadAvatar(Request $request)
    {
        # 判断上
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|file|max:2048', // 2MB Max Size
        ], [
            'required' => '请上传文件1',
            'file' => '请上传文件2',
            'max' => '头像最大只能上传两M.',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            throw new ApiException(RetConstant::FAIL, $validator->errors()->first());
        }

        $path = $request->file('avatar')->store(ConfigConstant::AVATAR_STORAGE_PATH);

        return succeed([
            'avatar' => substr(Storage::url($path), 1)
        ]);
    }

}
