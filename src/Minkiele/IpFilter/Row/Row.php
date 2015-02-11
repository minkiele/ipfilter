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

  public function getRangeStart(){
    return $this->rangeStart;
  }

  public function getRangeEnd(){
    return $this->rangeEnd;
  }

  public function getComment(){
    return $this->getComment;
  }

  public function getAccessLevel(){
    return $this->accessLevel();
  }

  public function intersects(Row $row){

    return ($row->getRangeStart()->compare($this->getRangeStart()) <= 0 && $this->getRangeStart()->compare($row->getRangeEnd()) <= 0) ||
           ($row->getRangeStart()->compare($this->getRangeEnd()) <= 0 && $this->getRangeEnd()->compare($row->getRangeEnd()) <= 0);

  }

  public function merge(Row $row){

    if($this->intersects($row)){
      //Overlaps preceeding
      if($row->getRangeStart()->compare($this->getRangeStart()) < 0 && $this->getRangeStart()->compare($row->getRangeEnd()) <= 0){
        //Extend start
        $this->rangeStart = $row->getRangeStart();
      }
      //Overlaps following
      if($row->getRangeStart()->compare($this->getRangeEnd()) <= 0 && $this->getRangeEnd()->compare($row->getRangeEnd()) < 0){
        //Extend end
        $this->rangeEnd = $row->getRangeEnd();
      }
    }else{
      throw new \Exception('IPs do not intersect');
    }
  }

  public function compare($row){

    if($this->getRangeStart()->compare($row->getRangeStart()) < 0){
      return -1;
    }else if($this->getRangeEnd()->compare($row->getRangeEnd()) > 0){
      return 1;
    }else{
      return 0;
    }

  }

  public function equals(Row $row){

    return $this->getRangeStart()->compare($row->getRangeStart()) === 0 &&
           $this->getRangeEnd()->compare($row->getRangeEnd()) === 0;
  }

}
