<?php

class CLogHelper
{
    const CLF = 'common'; 
    const CMB = 'combined';
    const COMMON = '%h %l %u %t \"%r\" %>s %b';  
    const COMBINED = '%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"';    
 
    protected static $format;
    protected static $fields = [
        'ip',    
        'hostname',
        'remotename',
        'user',
        'datetime',
        'query', 
        'status',
        'size',
        'server',        
        'referer',
        'useragent',
    ];
    
    protected static $parts = [
        '%a'     => '(\S+)',    
        '%h'     => '(\S+)',
        '%l'     => '(\S+)',
        '%u'     => '(\S+)',
        '%t'     => '\[([^:]+:\d+:\d+:\d+ [^\]]+)\]',
        '\"%r\"' => '\"(\S+\s.*?\s\S+)\"', 
        '%>s'    => '(\S+)',
        '%b'     => '(\S+)',
        '%v'     => '(\S+?):*',        
        '\"%{Referer}i\"'    => '\"(.*?)\"',
        '\"%{User-agent}i\"' => '\"(.*?)\"',
    ];
    
    /*
    *
    */
    public static function setFormat($format)
    {
        self::$format = $format; 
    }
    
    /*
    *
    */
    public static function parse($string)
    {
        self::createFormat(); 
        $direct = explode(' ', self::$format);
        $real = array_intersect(array_keys(self::$parts), $direct);
     
        $pattern = $order = [];        
        foreach($direct as $key => $val){
            if(isset(self::$parts[$val])){
                $pattern[$key] = self::$parts[$val];
                $order[++$key] = array_search($val, $real);                
            }
        }
        
        if(0 === preg_match('~'. implode(' ', $pattern) .'~', $string, $result)) {
            throw new \DomainException(sprintf(
            'Format "%s" is invalid. Сheck the settings in the config file', self::$format));
        }
        
        unset($result[0]);
        return self::normalizeResult($result, $order);
    } 
    
    /*
    *
    */
    protected static function normalizeResult($result, $order)
    {
        $out = [];
        foreach($order as $key => $val){
            $out[self::$fields[$val]] = $result[$key];
        }
        
        return $out;
    }
    
    /*
    *
    */
    protected static function createFormat()
    {
        $format = \Yii::app()->params['apache_log']['format'] ?: [];
        
        if(empty(self::$format)) { 
            self::$format = !empty($format['default']) ? $format['default'] : self::COMMON;
        }
     
        if(self::CLF === self::$format){
            self::$format = self::COMMON;
        } elseif (self::CMB === self::$format){
            self::$format = self::COMBINED;
        } elseif (isset($format[self::$format])){ 
            self::$format = $format[self::$format];
        }
        
        self::$format = preg_replace('~[^\s\\\a-z%">{}-]+~i', '', self::$format);
    } 
}
