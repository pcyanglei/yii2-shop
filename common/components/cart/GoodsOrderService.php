<?php

namespace common\components\cart;

use common\components\msg\MsgInterface;
use yii\base\Component;

/**
 * Created by PhpStorm.
 * User: pcyanglei
 * Date: 2017/12/6
 * Time: 下午5:40
 */
class GoodsOrderService extends Component
{
    const EVENT_COST = 'costCalc';
    protected $msgHandler;
    protected $goods = [];
    public function __construct(MsgInterface $msgHandler,array $config = [])
    {
        parent::__construct($config);
        $this->msgHandler = $msgHandler;
    }
    public function put(GoodsInterface $goods, $quantity = 1){
        $key = $goods->getKey();
        if (isset($this->goods[$key])) {
            $this->goods[$key]->setQuantity($quantity + $this->goods[$key]->getQuantity());
        } else {
            $goods->setQuantity($quantity);
            $this->goods[$key] = $goods;
        }
    }
    public function getCost($withDiscount = true): int
    {
        $cost = 0;
        foreach ($this->goods as $item) {
            $cost += $item->getCost();
        }
        $goodsOrderEvent = new GoodsOrderCalcEvent([
            'baseCost' => $cost,
        ]);
        $this->trigger(self::EVENT_COST, $goodsOrderEvent);
        if ($withDiscount) {
            $cost -= $goodsOrderEvent->discountValue;
        }
        $this->msgHandler->sendMsg("some message");
        return max(0, $cost);
    }

    /**
     * @return array
     */
    public function getGoods():string
    {
        return serialize($this->goods);
    }

}