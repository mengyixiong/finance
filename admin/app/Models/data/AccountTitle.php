<?php

namespace App\Models\data;

use Illuminate\Database\Eloquent\Model;

class AccountTitle extends Model
{
    protected $table = 'fx_account_titles';
    protected $primaryKey = 'id';

    /**
     * 不可以批量赋值的属性
     * @var string[]
     */
    protected $guarded = [];

    /**
     * 类型映射
     */
    const TYPE_ASSET = 'asset';
    const TYPE_PROFIT = 'profit';
    const TYPE_COST = 'cost';
    const TYPE_COMMON = 'common';
    const TYPE_OWNERSHIP = 'ownership';
    const TYPE_LIABILITIES = 'liabilities';
    const TYPE_SETTLEMENT = 'settlement';
    public static array $typeMap = [
        self::TYPE_ASSET => '资产类',
        self::TYPE_PROFIT => '损益类',
        self::TYPE_COST => '成本类',
        self::TYPE_COMMON => '共同类',
        self::TYPE_OWNERSHIP => '所有者权益类',
        self::TYPE_LIABILITIES => '负债类',
        self::TYPE_SETTLEMENT => '结算对象类',
    ];

    /**
     * 账页格式映射
     */
    const FORMAT_AMOUNT = 'amount';
    const FORMAT_CURRENCY_AMOUNT = 'currencyAmount';
    public static array $formatMap = [
        self::FORMAT_AMOUNT => '金额式',
        self::FORMAT_CURRENCY_AMOUNT => '外币式金额',
    ];

    /**
     * 等级映射
     */
    const LEVEL_1 = 1;
    const LEVEL_2 = 2;
    const LEVEL_3 = 3;
    const LEVEL_4 = 4;
    const LEVEL_5 = 5;
    public static array $levelMap = [
        self::LEVEL_1 => '1 级',
        self::LEVEL_2 => '2 级',
        self::LEVEL_3 => '3 级',
        self::LEVEL_4 => '4 级',
        self::LEVEL_5 => '5 级',
    ];

}
