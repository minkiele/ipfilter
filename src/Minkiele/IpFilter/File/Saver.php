<?php

namespace Minkiele\IpFilter\File;
use Minkiele\IpFilter\Document\Saver as DocumentSaver;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Saver implements DocumentSaver{

  private $handle;
  
  protected $dispatcher;

  public function __construct(EventDispatcher $dispatcher, $filename){
      $this->dispatcher = $dispatcher;
      $this->handle = fopen($filename, 'w+');
  }

  public function putRow($row){
      fwrite($this->handle, $row . PHP_EOL);
  }

  public function save(){
      fclose($this->handle);
  }

  public function __destruct(){
      if(is_resource($this->handle)){
          $this->save();
      }
  }
}
