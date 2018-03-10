<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "detail_log".
 *
 * @property integer $id
 * @property integer $user_account_id
 * @property string $amount
 * @property string $account_amount
 * @property integer $type
 * @property string $rmb
 * @property string $mount
 */
class DetailLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detail_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_account_id', 'mount'], 'required'],
            [['user_account_id', 'type'], 'integer'],
            [['amount', 'account_amount', 'rmb'], 'number'],
            [['mount'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_account_id' => 'User Account ID',
            'amount' => 'Amount',
            'account_amount' => 'Account Amount',
            'type' => 'Type',
            'rmb' => 'Rmb',
            'mount' => 'Mount',
        ];
    }
}
