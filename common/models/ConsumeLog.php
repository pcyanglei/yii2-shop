<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "consume_log".
 *
 * @property integer $id
 * @property integer $user_account_id
 * @property string $m_12
 * @property string $m_1
 * @property string $m_2
 * @property string $m_3
 * @property string $m_4
 * @property string $real_12_rmb
 * @property string $system_12_rmb
 * @property string $real_1_rmb
 * @property string $system_1_rmb
 * @property string $real_2_rmb
 * @property string $system_2_rmb
 * @property string $real_3_rmb
 * @property string $system_3_rmb
 * @property string $real_4_rmb
 * @property string $system_4_rmb
 */
class ConsumeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consume_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_account_id'], 'required'],
            [['user_account_id'], 'integer'],
            [['m_12', 'm_1', 'm_2', 'm_3', 'm_4', 'real_12_rmb', 'system_12_rmb', 'real_1_rmb', 'system_1_rmb', 'real_2_rmb', 'system_2_rmb', 'real_3_rmb', 'system_3_rmb', 'real_4_rmb', 'system_4_rmb'], 'number'],
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
            'm_12' => 'M 12',
            'm_1' => 'M 1',
            'm_2' => 'M 2',
            'm_3' => 'M 3',
            'm_4' => 'M 4',
            'real_12_rmb' => 'Real 12 Rmb',
            'system_12_rmb' => 'System 12 Rmb',
            'real_1_rmb' => 'Real 1 Rmb',
            'system_1_rmb' => 'System 1 Rmb',
            'real_2_rmb' => 'Real 2 Rmb',
            'system_2_rmb' => 'System 2 Rmb',
            'real_3_rmb' => 'Real 3 Rmb',
            'system_3_rmb' => 'System 3 Rmb',
            'real_4_rmb' => 'Real 4 Rmb',
            'system_4_rmb' => 'System 4 Rmb',
        ];
    }
}
