<?php

namespace Minkiele\IpFilter;
use Minkiele\IpFilter\Document\Reader;
use Minkiele\IpFilter\Document\Writer;
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

  public function read(Reader $reader, Translator $translator){

    $this->rows = [];
    $this->rawRows = [];
    foreach($reader as $line){
      try{
        $this->rows[] = $translator->parse($line);
      }catch(\Exception $exc){
        $this->rawRows[] = $line;
      }
    }
  }

  public function write(Writer $writer, Translator $translator){
    foreach($this->rows as $row){
        $writer->putRow($translator->format($row));
    }
  }

  public function sort(){

    usort($this->rows, function($rowA, $rowB){
      return $rowA->compare($rowB);
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
