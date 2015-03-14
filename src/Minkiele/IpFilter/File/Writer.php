<?php

namespace Minkiele\IpFilter\File;
use Minkiele\IpFilter\Document\Writer as DocumentWriter;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Writer implements DocumentWriter{

  private $handle;
  
  protected $dispatcher;

  public function __construct(EventDispatcher $dispatcher, $filename){
      $this->dispatcher = $dispatcher;
      $this->handle = fopen($filename, 'w+');
  }

  public function putRow($row){
      fwrite($this->handle, $row . PHP_EOL);
  }

  public function write(){
      fclose($this->handle);
  }

  public function __destruct(){
      if(is_resource($this->handle)){
          $this->write();
      }
  }
}
