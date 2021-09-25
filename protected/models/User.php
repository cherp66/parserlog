<?php

/**
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $token
 */
class User extends CActiveRecord
{
    /**
     * 
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 
     */
    public function rules()
    {
        return [
            ['username, password', 'required'],
            ['username, password', 'length', 'max' => 128],
        ];
    }
    
    /**
     * 
     */
    public function validatePassword($password)
    {
        return CPasswordHelper::verifyPassword($password, $this->password);
    }

    /**
     * 
     */
    public function hashPassword($password)
    {
        return CPasswordHelper::hashPassword($password);
    }
}
