<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "total_log".
 *
 * @property integer $id
 * @property integer $user_account_id
 * @property string $total_12
 * @property string $total_1
 * @property string $total_2
 * @property string $total_3
 * @property string $total_4
 */
class TotalLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'total_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_account_id', 'total_3'], 'required'],
            [['user_account_id'], 'integer'],
            [['total_12', 'total_1', 'total_2', 'total_3', 'total_4'], 'number'],
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
            'total_12' => 'Total 12',
            'total_1' => 'Total 1',
            'total_2' => 'Total 2',
            'total_3' => 'Total 3',
            'total_4' => 'Total 4',
        ];
    }
}
