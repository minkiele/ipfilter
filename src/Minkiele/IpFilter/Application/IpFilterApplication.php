<?php

namespace Minkiele\IpFilter\Application;

use Symfony\Component\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcher;

class IpFilterApplication extends Application{
    
    const APP_NAME = 'IpFilter';
    const APP_VERS = '0.2.0';
  
    public function __construct(){
        parent::__construct(self::APP_NAME, self::APP_VERS);
        $this->setDispatcher(new EventDispatcher());
        $this->add(new Command\Convert());
    }
  
}
