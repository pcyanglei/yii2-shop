<?php
namespace common\components\cart;
/**
 * Created by PhpStorm.
 * User: pcyanglei
 * Date: 2017/12/6
 * Time: 下午5:41
 */
interface GoodsInterface
{
    /**
     * @return int
     */
    public function getPrice():int;
    /**
     * @return string
     */
    public function getKey():string;
    /**
     * @param int $quantity
     * @return mixed
     */
    public function setQuantity(int $quantity);
    /**
     * @return int
     */
    public function getQuantity():int;
    /**
     * @return int
     */
    public function getCost():int;
}