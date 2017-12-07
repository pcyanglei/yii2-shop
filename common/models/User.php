<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $phone
 *
 * @property GoodsOrder[] $goodsOrders
 */
class User extends \yii\db\ActiveRecord
{
    const ACTIVE_STATU  = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'phone'], 'required'],
            [['username'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'phone' => '电话',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsOrders()
    {
        return $this->hasMany(GoodsOrder::className(), ['user_id' => 'id']);
    }
}
