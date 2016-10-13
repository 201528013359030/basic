<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "a_employee".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string $department
 * @property string $position
 */
class Employee extends \yii\db\ActiveRecord
{

	public static function getDb()
	{
		return \Yii::$app->db;  // 使用名为 "db2" 的应用组件
	}

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
            [['username'], 'unique'],
            [['email'], 'unique'],
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
