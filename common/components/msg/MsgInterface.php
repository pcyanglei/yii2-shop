<?php
namespace common\components\msg;
/**
 * Created by PhpStorm.
 * User: pcyanglei
 * Date: 2017/12/6
 * Time: 下午6:23
 */
interface MsgInterface
{
    public function sendMsg(string $data);
}