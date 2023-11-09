<?php

namespace App\Http\Requests\data;

use App\Models\data\AccountTitle;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountTitleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $types = implode(',', array_keys(AccountTitle::$typeMap));
        $formats = implode(',', array_keys(AccountTitle::$formatMap));

        return [
            'pid' => 'required|integer',
            'level' => 'required|integer',
            'code' => 'required|string|max:100',
            'cn_name' => 'nullable|string|max:100',
            'en_name' => 'nullable|string|max:100',
            'type' => 'required|string|max:20|in:' . $types,
            'format' => 'required|string|max:20|in:' . $formats,
            'abb' => 'nullable|string|max:100',
            'currency' => 'required|string|max:10',
            'com_id' => 'required|integer',
            'is_foreign' => 'required|in:Y,N',
            'is_dn' => 'required|in:Y,N',
            'is_freezed' => 'required|in:Y,N',
            'is_cash' => 'required|in:Y,N',
            'is_last' => 'required|in:Y,N',
            'balance' => 'nullable|numeric',
            'currency_balance' => 'nullable|numeric',
            'year_begining' => 'nullable|numeric',
            'year_begining_currency' => 'nullable|numeric',
            'account_opening' => 'nullable|numeric',
            'account_opening_currency' => 'nullable|numeric',
            'vender_required' => 'required|in:Y,N',
            'clerk_required' => 'required|in:Y,N',
            'team_required' => 'required|in:Y,N',
            'branch_required' => 'required|in:Y,N',
            'created_by' => 'required|integer',
            'updated_by' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'pid.required' => '必须指定上一级科目。',
            'pid.integer' => '上一级科目ID必须是整数。',
            'level.required' => '级次为必填项。',
            'level.integer' => '级次必须是整数。',
            'code.required' => '科目代码为必填项。',
            'code.string' => '科目代码必须是字符串。',
            'code.max' => '科目代码的最大长度为100个字符。',
            'cn_name.string' => '中文名必须是字符串。',
            'cn_name.max' => '中文名的最大长度为100个字符。',
            'en_name.string' => '英文名必须是字符串。',
            'en_name.max' => '英文名的最大长度为100个字符。',
            'type.required' => '科目类型为必填项。',
            'type.string' => '科目类型必须是字符串。',
            'type.in' => '提供的科目类型无效。',
            'format.required' => '账页格式为必填项。',
            'format.string' => '账页格式必须是字符串。',
            'format.in' => '提供的账页格式无效。',
            'abb.string' => '助记码必须是字符串。',
            'abb.max' => '助记码的最大长度为100个字符。',
            'currency.required' => '核算币种为必填项。',
            'currency.string' => '核算币种必须是字符串。',
            'currency.max' => '核算币种的最大长度为10个字符。',
            'com_id.required' => '公司ID为必填项。',
            'com_id.integer' => '公司ID必须是整数。',
            'is_foreign.required' => '外币核算标志为必填项。',
            'is_foreign.in' => '外币核算标志必须是‘Y’或‘N’。',
            'is_dn.required' => '余额方向标志为必填项。',
            'is_dn.in' => '余额方向标志必须是‘Y’或‘N’。',
            'is_freezed.required' => '冻结标志为必填项。',
            'is_freezed.in' => '冻结标志必须是‘Y’或‘N’。',
            'is_cash.required' => '是否现金流科目标志为必填项。',
            'is_cash.in' => '现金流科目标志必须是‘Y’或‘N’。',
            'is_last.required' => '末级科目标志为必填项。',
            'is_last.in' => '末级科目标志必须是‘Y’或‘N’。',
            'balance.numeric' => '期末余额必须是数字。',
            'currency_balance.numeric' => '核算币种余额必须是数字。',
            'year_begining.numeric' => '年初余额必须是数字。',
            'year_begining_currency.numeric' => '年初余额(核算币种)必须是数字。',
            'account_opening.numeric' => '开户时的余额必须是数字。',
            'account_opening_currency.numeric' => '开户时的余额(核算币种)必须是数字。',
            'vender_required.required' => '往来单位是否必填标志为必填项。',
            'vender_required.in' => '往来单位是否必填标志必须是‘Y’或‘N’。',
            'clerk_required.required' => '员工是否必填标志为必填项。',
            'clerk_required.in' => '员工是否必填标志必须是‘Y’或‘N’。',
            'team_required.required' => '部门是否必填标志为必填项。',
            'team_required.in' => '部门是否必填标志必须是‘Y’或‘N’。',
            'branch_required.required' => '分公司是否必填标志为必填项。',
            'branch_required.in' => '分公司是否必填标志必须是‘Y’或‘N’。',
            'created_by.integer' => '创建人ID必须是整数。',
            'created_at.date' => '创建时间必须是有效的日期。',
            'updated_at.date' => '更新时间必须是有效的日期。',
            'updated_by.required_without' => '在更新记录时，必须提供更新人信息。',
            'updated_by.integer' => '更新人ID必须是整数。',
        ];
    }
}
