<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "charge_log".
 *
 * @property integer $id
 * @property string $amount
 * @property integer $type
 * @property integer $user_account_id
 * @property string $created_at
 * @property string $desc
 * @property integer $flag
 * @property string $balance
 */
class ChargeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charge_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'user_account_id', 'created_at'], 'required'],
            [['amount', 'balance'], 'number'],
            [['type', 'user_account_id', 'flag'], 'integer'],
            [['created_at'], 'safe'],
            [['desc'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'type' => 'Type',
            'user_account_id' => 'User Account ID',
            'created_at' => 'Created At',
            'desc' => 'Desc',
            'flag' => 'Flag',
            'balance' => 'Balance',
        ];
    }
}
