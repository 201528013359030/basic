<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qingjiatiao".
 *
 * @property integer $Id
 * @property string $name
 * @property string $type
 * @property string $startDate
 * @property string $endDate
 * @property string $approveId
 * @property string $informId
 * @property string $reason
 * @property string $hand
 */
class Qingjiatiao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qingjiatiao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reason', 'hand'], 'string'],
            [['name', 'type', 'startDate', 'endDate', 'approveId', 'informId'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'approveId' => 'Approve ID',
            'informId' => 'Inform ID',
            'reason' => 'Reason',
            'hand' => 'Hand',
        ];
    }
}
