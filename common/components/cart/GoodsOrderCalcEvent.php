<?php
namespace common\components\cart;
use yii\base\Event;

/**
 * Created by PhpStorm.
 * User: pcyanglei
 * Date: 2017/12/6
 * Time: 下午6:46
 */

class GoodsOrderCalcEvent extends Event
{
    public $baseCost;
    public $discountValue = 0;
}