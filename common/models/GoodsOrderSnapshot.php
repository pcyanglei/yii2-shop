<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_order_snapshot".
 *
 * @property integer $id
 * @property string $content
 * @property integer $goods_order_id
 *
 * @property GoodsOrder $goodsOrder
 */
class GoodsOrderSnapshot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_order_snapshot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['goods_order_id'], 'required'],
            [['goods_order_id'], 'integer'],
            [['goods_order_id'], 'unique'],
            [['goods_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => GoodsOrder::className(), 'targetAttribute' => ['goods_order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '快照内容',
            'goods_order_id' => 'Goods Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsOrder()
    {
        return $this->hasOne(GoodsOrder::className(), ['id' => 'goods_order_id']);
    }
}
