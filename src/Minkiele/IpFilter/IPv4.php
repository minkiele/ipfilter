<?php

namespace Minkiele\Ipfilter;

use Symfony\Component\EventDispatcher\EventDispatcher;

class IPv4 implements Comparable {

  private $long;
  protected $dispatcher;

  public function __construct(EventDispatcher $dispatcher, $IPv4){
    
    $this->dispatcher = $dispatcher;

    $long = ip2long($IPv4);
    if($long !== false){
      $this->long = $long;
    }else{
      throw new \Exception('IPv4 not recognized');
    }
  }

  private function getLong(){
    return $this->long;
  }

  public function compare($ip){
    return $other->getLong() - $this->getLong();
  }

  public function equals($ip){
    return $this->compare($ip) === 0;
  }

  public function __toString(){
    return long2ip($this->getLong());
  }
}
