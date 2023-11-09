<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * 工具类
 */
class ToolUtils
{

    /**
     * 更新表结构
     * @return void
     */
    public static function updateTableStructure($tableName)
    {
        // 获取表的所有列的信息
        $columnsInfo = DB::select("SHOW FULL COLUMNS FROM $tableName");

        foreach ($columnsInfo as $columnInfo) {
            $column = $columnInfo->Field;
            $type = $columnInfo->Type;
            $comment = $columnInfo->Comment;

            if ($column !== Str::snake($column)) {
                $newColumnName = Str::snake($column);

                // 重命名字段并保留原有的类型和注释
                DB::statement("ALTER TABLE $tableName CHANGE $column $newColumnName $type COMMENT '$comment'");
            }
        }

    }
}
