<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "a_employee".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string $department
 * @property string $position
 */
class ALeavebill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'a_employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'email', 'role', 'department', 'position'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'email' => 'Email',
            'role' => 'Role',
            'department' => 'Department',
            'position' => 'Position',
        ];
    }
}
