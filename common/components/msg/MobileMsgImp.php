<?php

use common\components\msg\MsgInterface;

/**
 * Created by PhpStorm.
 * User: pcyanglei
 * Date: 2017/12/6
 * Time: 下午6:25
 */
class MobileMsgImp implements MsgInterface
{

    public function sendMsg(string $data)
    {
        \Yii::info("移动---短信已发送!");
    }
}