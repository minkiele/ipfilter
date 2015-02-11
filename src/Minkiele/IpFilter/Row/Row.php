<?php

namespace Minkiele\IpFilter\Row;

use Minkiele\IpFilter\IPv4;
use Minkiele\IpFilter\Comparable;

class Row implements Comparable {
  
  const ACCESS_LEVEL_DENY = '000';
  
  private $rangeStart;
  private $rangeEnd;
  private $accessLevel;
  private $comment;
  
  public function __construct(IPv4 $rangeStart, IPv4 $rangeEnd, $comment = '', $accessLevel = self::ACCESS_LEVEL_DENY){
    $this->rangeStart = $rangeStart;
    $this->rangeEnd = $rangeEnd;
    $this->accessLevel = $accessLevel;
    $this->comment = $comment;
  }
  
  public function intersects(Row $row){

    return ($row->rangeStart->compare($this->rangeStart) <= 0 && $this->rangeStart->compare($row->rangeEnd) <= 0) ||
           ($row->rangeStart->compare($this->rangeEnd) <= 0 && $this->rangeEnd->compare($row->rangeEnd) <= 0);

  }
  
  public function merge(Row $row){

    if($this->intersects($row)){
      //Overlaps preceeding
      if($row->rangeStart->compare($this->rangeStart) < 0 && $this->rangeStart->compare($row->rangeEnd) <= 0){
        //Extend start
        $this->rangeStart = $row->rangeStart;
      }
      //Overlaps following
      if($row->rangeStart->compare($this->rangeEnd) <= 0 && $this->rangeEnd->compare($row->rangeEnd) < 0){
        //Extend end
        $this->rangeEnd = $row->rangeEnd;
      }
    }else{
      throw new \Exception('IPs do not intersect');
    }
  }
  
  public function compare($row){

    if($this->rangeStart->compare($row->rangeStart) < 0){
      return -1;
    }else if($this->rangeEnd->compare($row->rangeEnd) > 0){
      return 1;
    }else{
      return 0;
    }
    
  }
  
  public function equals(Row $row){
  
    return $this->rangeStart->compare($row->rangeStart) === 0 &&
           $this->rangeEnd->compare($row->rangeEnd) === 0;
  }

}
