<?php

namespace App\Http\Requests;

use App\Constant\RetConstant;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{

    /**
     * 自定义错误
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        # 提示第一个信息
        foreach ($validator->errors()->messages() as $error) {
            $response = erred(RetConstant::FIELD_VALIDATION_FAIL, $error[0]);
            throw new HttpResponseException($response);
        }
    }

}
