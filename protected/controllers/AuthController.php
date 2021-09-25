<?php

/**
 * 
 */
class AuthController extends CController
{
    protected $post;

    /**
     * 
     */
    public function beforeAction($action)
    {
        $this->post = json_decode(file_get_contents('php://input'), true);
        return parent::beforeAction($action);
    }

    /**
     * 
     */
    public function actionLogin()
    {
        $model = new LoginForm;
        $model->attributes = $this->post;
        if($model->validate() && $model->login()) {
            echo json_encode(['token' => \Yii::app()->user->token]);
        } else {
            $message = implode(' ', array_map(function ($errors) {
                return implode('', $errors);
            }, array_unique($model->getErrors())));
            echo json_encode(['errors' => $message]);
        }
        \Yii::app()->end();
    }
    
    /**
     * 
     */
    public function actionLogout()
    {
        $user = User::model()->find('token=?', [$this->post['token']]);
        if(is_object($user)){
            $user->token = null;
            $user->save();
        }    
        \Yii::app()->end();
    }
}
