<?php
namespace common\components\base;
use common\helpers\MoneyHelper;
use \yii\i18n\Formatter as BaseFormatter;
/**
 * Created by PhpStorm.
 * User: pcyanglei
 * Date: 2017/12/6
 * Time: 下午1:02
 */
class Formatter extends BaseFormatter
{
    /**
     * @param string $value the value to be formatted.
     * @return string the formatted result.
     */
    public function asMoney(int $value):string
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        return (string) MoneyHelper::f2y($value) . '元';
    }
}