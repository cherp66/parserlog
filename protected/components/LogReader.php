<?php

/**
 * 
 */
class LogReader
{
    /**
     * 
     */
    public static function getAll($limit = 10, $offset = 0)
    {
        return \Yii::app()->db->createCommand()
            ->select('ip, datetime, query, status, referer, useragent')
            ->from('apache_log')
            ->order('id ASC')
            ->limit($limit)
            ->offset($offset)
            ->queryAll();
    }
    
    /**
     * 
     */
    public static function getGroupIp($ip)
    {
       
    }
    
    /**
     * 
     */
    public static function getGroupDate($date)
    {
       
    }
    
    /**
     * 
     */
    public static function getPeriod($dateFrom, $dateTo)
    {
       
    }
}
