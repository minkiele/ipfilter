<?php

namespace Minkiele\IpFilter;
use Minkiele\IpFilter\Document\Loader;
use Minkiele\IpFilter\Document\Saver;
use Minkiele\IpFilter\Row\Translator;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Table{

  protected $translator;
  protected $rows;
  protected $rawRows;
  protected $dispatcher;

  public function __construct(EventDispatcher $dispatcher){
    $this->rows = [];
    $this->rawRows = [];
    $this->dispatcher = $dispatcher;
  }

  public function load(Loader $loader, Translator $translator){

    $this->rows = [];
    $this->rawRows = [];

    foreach($loader as $line){
      try{
        $this->rows[] = $translator->parse($line);
      }catch(\Exception $exc){
        $this->rawRows[] = $line;
      }
    }
  }

  public function save(Saver $saver, Translator $translator){
    foreach($this->rows as $row){
        $saver->putRow($translator->format($row));
    }
  }

  public function sort(){

    usort($this->rows, function($rowA, $rowB){
      return $rowA->cmp($rowB);
    });

  }

  public function merge(){
    $count = count($this->rows);
    if($count > 0){

      $this->sort();

      $sets = [];
      $sets[] = array_shift($this->rows);

      foreach($this->rows as $row){
        $merged = false;
        foreach($sets as $set){
          if($set->intersects($row)){
            $set->merge($row);
            $merged = true;
            break;
          }
        }
        if(!$merged){
          $sets[] = $row;
        }
      }

      $this->rows = $sets;
      unset($sets);

      if(count($this->rows) < $count){
        //There has been a reduction, I can try another round
        $this->merge();
      }

    }

  }

}
