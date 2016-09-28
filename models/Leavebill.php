<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leavebill".
 *
 * @property string $id
 * @property string $userid
 * @property string $leaveType
 * @property string $leaveStartTime
 * @property string $leaveEndTime
 * @property string $reason
 * @property string $remark
 * @property string $applyTime
 * @property integer $state
 * @property string $username
 * @property double $days
 * @property string $dep
 * @property string $spuser
 * @property string $tzuser
 * @property string $tongzhi
 * @property string $token
 * @property string $approvalPerson
 */
class Leavebill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'leavebill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['leaveStartTime', 'leaveEndTime', 'applyTime'], 'safe'],
            [['state'], 'integer'],
            [['days'], 'number'],
            [['id'], 'string', 'max' => 15],
            [['userid', 'leaveType', 'reason', 'remark', 'username', 'dep', 'spuser', 'token', 'approvalPerson'], 'string', 'max' => 255],
            [['tzuser'], 'string', 'max' => 1500],
            [['tongzhi'], 'string', 'max' => 2500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'leaveType' => 'Leave Type',
            'leaveStartTime' => 'Leave Start Time',
            'leaveEndTime' => 'Leave End Time',
            'reason' => 'Reason',
            'remark' => 'Remark',
            'applyTime' => 'Apply Time',
            'state' => 'State',
            'username' => 'Username',
            'days' => 'Days',
            'dep' => 'Dep',
            'spuser' => 'Spuser',
            'tzuser' => 'Tzuser',
            'tongzhi' => 'Tongzhi',
            'token' => 'Token',
            'approvalPerson' => 'Approval Person',
        ];
    }
}
