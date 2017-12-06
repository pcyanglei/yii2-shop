<?php
namespace common\components\msg;

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
        \Yii::warning("移动---短信已发送!");
    }
}