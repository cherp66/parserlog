<?php

class ParseLogCommand extends CConsoleCommand
{
    use CmdTrait;
    
    private $part = [];
    private $cnt = 0;
    private $fields = [
        'ip' => null, 
        'datetime' => null, 
        'query' => null, 
        'hostname' => null, 
        'remotename' => null, 
        'user' => null, 
        'status' => null, 
        'size' => null, 
        'server' => null, 
        'referer' => null, 
        'useragent' => null 
    ];
    
    /*
    *
    */    
    public function run($args) 
    {
        if(!empty($args[0]) && ('-help' === $args[0] || '-h' === $args[0])){
            $this->phrase($this->help());
            return;
        }
        
        $file = $args[0] ?? null;
        
        if(false !== ($logFile = $this->getLogFile($file))){
         
            if(!empty($args[1])){
                CLogHelper::setFormat($args[1]);
            } 
         
            $this->phrase('Идет обработка');
            
            if($this->process($logFile)){
                $this->clear();
                $this->phrase('Готово'); 
                $result = $this->confirm('Очистить файл лога? [y|n]');
                if(1 === $result){
                    file_put_contents($logFile, '');
                    $this->phrase('Файл лога очищен');
                }
            }
        }    
    }
    
    /*
    *
    */    
    protected function getLogFile($file) 
    { 
        $files = \Yii::app()->params['apache_log']['logfiles'] ?: [];
        
        if(!empty($file)){
            if(isset($files[$file])){
                $logFile = $files[$file];
            } else {
                $logFile = $file;
            }
        } else {
            $logFile = $files['default'] ?: null;    
        }
        
        if(!empty($logFile) && !file_exists($logFile)){
            $this->phrase('Файл логов по пути "'. $logFile .'" не найден'); 
            return false;
        } elseif(empty($logFile)) {
            $this->phrase('Путь до файла логов не установлен'); 
            return false;
        }
        
        return $logFile;
    }
    
    /*
    *
    */    
    protected function process($logFile) 
    {    
        if(false !== ($handle = @fopen($logFile, 'r'))) {
            while(false !== ($string = fgets($handle, 4096))) {
                if(false === $this->save($string)){
                    return false;
                }
            }
            fclose($handle);
        } else {
            $this->phrase('Ошибка открытия файла '. $logFile); 
            return false;
        }
        
        if(!empty($this->part)){
            $this->insert();
        } 
        
           return true;
    }
    
    /*
    *
    */    
    protected function save($string) 
    {
        try{
            $data = CLogHelper::parse($string);
        } catch (\DomainException $e) {
            $this->clear();
            $this->phrase('Ошибка: '. $e->getMessage());
            return false;
        }
        
        $data = array_merge($this->fields, $data);
        $this->part[] = $this->createInsertString($data);
        $this->createBar($this->cnt++);    
        usleep(50000);
        $this->insertPart();
        return true;
    }
    
    /*
    *
    */    
    protected function createInsertString($data) 
    {
        $data['datetime'] = $this->parseData($data['datetime']);
        return "('". implode("', '", $data) ."')";
    } 
    
    /*
    *
    */    
    protected function parseData($datetime) 
    {
        return !empty($datetime) ? date('Y-m-d H:i:s', strtotime($datetime)) : null;
    }

    /*
    *
    */    
    protected function insertPart() 
    {
        if($this->cnt > 100){ 
            $this->cnt = 0;
            $this->insert();
            $this->part = [];
        }
    }
    
    /*
    *
    */    
    protected function insert() 
    {
        $command = \Yii::app()->db->createCommand();
        $command->setText("INSERT IGNORE INTO `apache_log` "
            ."(`". implode("`, `", array_keys($this->fields)) ."`)
        VALUES "
            . implode(",\n", $this->part)
        );
        $command->execute();
    }
    
   
    /*
    *
    */ 
    protected function help()
    {    
        return  <<<EOD
        
 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        
        Команда:
        parselog                |  Разбор файла логов по дефолтным
                                |  параметрам, уcтановленным 
                                |  в конфигурационном файле
         
            Параметры:          
            [-help|-h]          |  Справка
         
            [log_file]  [mask]  |  Путь до файла (абсолютный) или алиас
                                |  и маска лога. 
                                |  Возможные варианты маски
                                |     1. common
                                |     2. combined
                                      3. имя маски в конфигурационном файле
                                |     4. кастомная маска (%h %l %u ...)

 - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -     
EOD;
    }
}
