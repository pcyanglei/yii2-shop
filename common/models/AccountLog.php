<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "account_log".
 *
 * @property integer $account_log_id
 * @property integer $account_log_account_id
 * @property string $account_log_serial_number
 * @property string $account_log_amount
 * @property string $account_log_balance
 * @property integer $account_log_type
 * @property integer $account_log_status
 * @property integer $account_log_real
 * @property string $account_log_desc
 * @property string $account_log_other
 * @property string $account_log_create_at
 * @property string $account_log_update_at
 * @property string $account_log_finish_at
 * @property integer $flag
 */
class AccountLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_log_account_id'], 'required'],
            [['account_log_account_id', 'account_log_type', 'account_log_status', 'account_log_real', 'flag'], 'integer'],
            [['account_log_amount', 'account_log_balance'], 'number'],
            [['account_log_create_at', 'account_log_update_at', 'account_log_finish_at'], 'safe'],
            [['account_log_serial_number'], 'string', 'max' => 32],
            [['account_log_desc', 'account_log_other'], 'string', 'max' => 512],
            [['account_log_serial_number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_log_id' => 'Account Log ID',
            'account_log_account_id' => 'Account Log Account ID',
            'account_log_serial_number' => 'Account Log Serial Number',
            'account_log_amount' => 'Account Log Amount',
            'account_log_balance' => 'Account Log Balance',
            'account_log_type' => 'Account Log Type',
            'account_log_status' => 'Account Log Status',
            'account_log_real' => 'Account Log Real',
            'account_log_desc' => 'Account Log Desc',
            'account_log_other' => 'Account Log Other',
            'account_log_create_at' => 'Account Log Create At',
            'account_log_update_at' => 'Account Log Update At',
            'account_log_finish_at' => 'Account Log Finish At',
            'flag' => 'Flag',
        ];
    }
}
