<?php

/**
 * 
 */
class LoginForm extends CFormModel
{
    public $username;
    public $password;

    private $identity;

    /**
     * 
     */
    public function rules()
    {
        return [
            ['username, password', 'required', 'message' => 'Заполните все поля'],
            ['password', 'authenticate'],
        ];
    }

    /**
     * 
     */
    public function authenticate($attribute, $params)
    {
        if(!empty($this->password)){
            $this->identity = new UserIdentity($this->username, $this->password);    
            if(!$this->identity->authenticate()) {
                $this->addError('password', 'Неверно набран логин или пароль');
            }
        }
    }

    /**
     * 
     */
    public function login()
    {
        if(null === $this->identity){
            $this->identity = new UserIdentity($this->username, $this->password);
            $this->identity->authenticate();
        }
        
        if($this->identity->errorCode === UserIdentity::ERROR_NONE){
            $user = Yii::app()->user;
            $user->login($this->identity);
            return true;
        } 
        
        return false;
    }
}
