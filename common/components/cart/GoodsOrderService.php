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
    /**
     * @var MsgInterface
     */
    protected $msgHandler;
    /**
     * @var GoodsInterface[]
     */
    protected $goods = [];

    /**
     * GoodsOrderService constructor.
     * @param array $config
     * @param MsgInterface $msgHandler
     */
    public function __construct(array $config = [], MsgInterface $msgHandler)
    {
        parent::__construct($config);
        $this->msgHandler = $msgHandler;
    }

    /**
     * @param GoodsInterface $goods
     * @param int $quantity
     */
    public function put($goods, $quantity = 1)
    {
        $key = $goods->getKey();
        if (isset($this->goods[$key])) {
            $this->goods[$key]->setQuantity($quantity + $this->goods[$key]->getQuantity());
        } else {
            $goods->setQuantity($quantity);
            $this->goods[$key] = $goods;
        }
    }

    /**
     * @param bool $withDiscount
     * @return int
     */
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
        $this->msgHandler->sendMsg("......");
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