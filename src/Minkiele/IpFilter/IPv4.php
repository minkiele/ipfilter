<?php

namespace Minkiele\Ipfilter;

class IPv4 implements Comparable {

  private $long;

  public function __construct($IPv4){
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
