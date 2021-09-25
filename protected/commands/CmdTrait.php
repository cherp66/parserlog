<?php
 
/** 
 * 
 */  
trait CmdTrait
{
    /**
    * 
    */     
    public function end($message)
    {
        if($this->hasAnsi()){
            $this->clear();
            $this->write(PHP_EOL);
            $this->write($message);
            $this->write(PHP_EOL);
            $this->write(PHP_EOL);
        }
    }   
    
    /**
    * 
    */    
    public function clear()
    {
        $this->write("\x0D");
        $this->write("\x1B[2K");
    }

    /**
    * 
    */    
    public function phrase($phrase)
    {
        $this->write($phrase);
        $this->write(PHP_EOL);
    } 
    
    /**
    * 
    */    
    public function write($message)
    {
        file_put_contents('php://stdout', $message);
    } 

    /**
    * 
    */     
    public function createBar($cnt)
    { 
        if($this->hasAnsi()){    
            $progress = '[';
            for($i = 0; $i <= 10; $i++){
                if($i == $cnt) {
                    $progress .= '=>';            
                } else {
                    $progress .= '-';            
                }
            }
            $progress .= ']';
            $this->clear();
            $this->write($progress);
        } else {
            $this->write(PHP_EOL);
            $this->write("..");
            $this->write(PHP_EOL);
        }
    }    
    
    /**
    *
    */ 
    public function confirm($message, $default = null)
    {
        print("\n". $message);
        $std = fopen("php://stdin", "r");        
        $line = trim(strtolower(fgets($std)));
     
        switch($line) {
            case 'y':
            case 'yes':
                fclose($std);
                return 1;       
            case 'n' :
            case 'no':
                fclose($std);
                return 2;
            case '':
                $this->phrase('Сonfirmation required');
                $this->confirm($message);                
            default:
                $this->phrase(sprintf('Command "%s" not recognized', $line));
                $this->confirm($message);
        }      
        return false;
    }    
    
    /**
    *
    */     
    protected function hasAnsi() : bool
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return
                0 >= version_compare(
                    '10.0.10586',
                    PHP_WINDOWS_VERSION_MAJOR . '.' . PHP_WINDOWS_VERSION_MINOR . '.' . PHP_WINDOWS_VERSION_BUILD
                )
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }
     
        return false;
    }
}
    