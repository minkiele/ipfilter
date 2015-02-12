<?php

namespace Minkiele\IpFilter;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Dispatcher{
    private static $dispatcher = null;
    
    public static function getDispatcher(){
        if(self::$dispatcher === null){
            self::$dispatcher = new EventDispatcher();
        }
        
        return self::$dispatcher;
    }
    
}
