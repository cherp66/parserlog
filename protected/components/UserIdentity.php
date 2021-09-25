<?php

/**
 * 
 */
class UserIdentity extends CUserIdentity
{
    const ERROR_SYSTEM = 10;
    private $id;

    /**
     * 
     */
    public function authenticate()
    {
        $user = User::model()->find('LOWER(username)=?', [strtolower($this->username)]);
        
        if(null === $user) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif(!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->id = $user->id;
            $this->username = $user->username;
            $user->token = md5(microtime(true));
            if(!$user->save()) {
                $this->errorCode = self::ERROR_SYSTEM;
            } else {
                $this->setState('token', $user->token);
                $this->errorCode = self::ERROR_NONE;
            }
        }
        
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * 
     */
    public function getId()
    {
        return $this->id;
    }
}