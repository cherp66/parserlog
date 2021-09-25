<?php

/**
 * 
 */
class ApachelogController extends CController
{
    /**
     * 
     */
    public function filters()
    {
        return [
            'accessToken + content'
        ];
    }
    
    /**
     * 
     */
    public function filterAccessToken($filterChain)
    {        
        $post = json_decode(file_get_contents('php://input'), true);
        $auth = false;
     
        if(!empty($post['token'])){
            $auth = (bool)User::model()->count('token=?', [$post['token']]);
        }
        
        if(!$auth){
            \Yii::app()->end();
        }
        
        $filterChain->run();  
    }

    /**
     * 
     */
    public function actionIndex()
    {
        $this->renderPartial('views.main');
    }
    
    /**
     * 
     */
    public function actionContent()
    {
        $logs = LogReader::getAll();  
        echo json_encode(['content' => $logs]);
        \Yii::app()->end();
    }
}
