<?php
namespace common\helpers;
/**
 * Created by PhpStorm.
 * User: pcyanglei
 * Date: 2017/12/6
 * Time: 下午1:12
 */
class MoneyHelper
{
    /**
     * @param int $value
     * @return float
     */
    public final static function f2y(int $value): float
    {
        return $value / 100;
    }
}