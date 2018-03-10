<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_order".
 *
 * @property integer $id
 * @property string $sn
 * @property integer $total_price
 * @property integer $user_id
 *
 * @property User $user
 * @property GoodsOrderSnapshot $goodsOrderSnapshot
 */
class GoodsOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sn', 'total_price', 'user_id'], 'required'],
            [['total_price', 'user_id'], 'integer'],
            [['sn'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => '序号',
            'total_price' => '总价',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsOrderSnapshot()
    {
        return $this->hasOne(GoodsOrderSnapshot::className(), ['goods_order_id' => 'id']);
    }
}
