<?php

namespace App\Logics\data;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\data\AccountTitle;
use Illuminate\Support\Facades\Log;

class AccountTitleLogic
{
    /**
     * 导入rq物流系统数据
     * @return void
     */
    public function importRqSystemData()
    {
        $rqData = DB::connection('mysql_rq_dev')
            ->table('fx_account_titles')
            ->get()->toArray();
        $newData = [];
        foreach ($rqData as $data) {
            $newData[] = [
                "id" => $data->id,
                "pid" => $data->pid,
                "level" => $data->level,
                "code" => $data->code,
                "cn_name" => $data->cnName,
                "en_name" => $data->enName,
                "type" => $data->type,
                "format" => $data->format,
                "abb" => $data->abb,
                "currency" => $data->currency,
                "com_id" => $data->companyId ?: 1,
                "is_foreign" => $data->isForeign,
                "is_dn" => $data->isDn,
                "is_freezed" => $data->isFreezed,
                "is_cash" => $data->isCash,
                "is_last" => $data->isLast,
                "balance" => $data->balance,
                "currency_balance" => $data->currencyBalance,
                "year_begining" => $data->yearBegining,
                "year_begining_currency" => $data->yearBeginingUsd,
                "account_opening" => $data->accountOpening,
                "account_opening_currency" => $data->accountOpeningUsd,
                "vender_required" => $data->venderRequired,
                "clerk_required" => $data->clerkRequired,
                "team_required" => $data->teamRequired,
                "branch_required" => $data->branchRequired,
                "created_by" => 1,
                "updated_by" => 1,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];
        }
        DB::table('fx_account_titles')->insert($newData);
    }

    /**
     * 获取页面配置数据
     */
    public function pageConfig()
    {
        return [
            'type' => AccountTitle::TYPE_ASSET,
            'types' => map2Options(AccountTitle::$typeMap),
            'formats' => map2Options(AccountTitle::$formatMap),
            'levels' => map2Options(AccountTitle::$levelMap)
        ];
    }

    /**
     * 获取分页数据
     */
    public function getList(Request $request)
    {
        $limit = $request->input('limit', 15);
        $query = AccountTitle::query();

        $query->where('com_id',1);

        # 科目名称
        if ($request->has('keyword')) {
            $query->where(function (Builder $query) use ($request) {
                $query
                    ->where('cn_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('en_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('code', 'like', '%' . $request->keyword . '%');
            });
        }

        # 格式
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $query->orderBy('id', 'ASC');
        $data = $query->paginate($limit);
        $data->getCollection()->transform(function ($item) {
            $item->formatText = AccountTitle::$formatMap[$item->format] ?? '';
            $item->typeText = AccountTitle::$typeMap[$item->type] ?? '';
            return $item;
        });
        return $data;
    }
}
