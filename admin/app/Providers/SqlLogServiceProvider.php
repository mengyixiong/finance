<?php

namespace App\Providers;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SqlLogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        DB::listen(function ($query) {
            // 使用 Log facade 记录 SQL 查询
            Log::channel('sql')->info(
                $query->sql,
                [
                    'time' => $query->time,
                    'bindings' => $query->bindings,
                ]
            );
        });
    }

}
