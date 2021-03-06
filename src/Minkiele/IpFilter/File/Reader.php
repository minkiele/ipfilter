<?php

namespace Minkiele\IpFilter\File;
use Minkiele\IpFilter\Document\Reader as DocumentReader;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Reader implements DocumentReader{

    private $filename;
    private $handle;
    private $dirty;
    private $current;
    private $index;
  
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher, $filename){
      $this->dispatcher = $dispatcher;
        $this->filename = $filename;
        $this->read();
    }

    public function current() {
        if(!$this->dirty){
            $this->current = fgets($this->handle);
            $this->dirty = true;
        }
        return $this->current;
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->current = fgets($this->handle);
        $this->index++;
    }

    public function rewind() {
        fseek($this->handle, 0);
        $this->dirty = false;
        $this->current = false;
        $this->index = 0;
    }

    public function valid() {
        return $this->current !== false || !$this->dirty;
    }

    public function __destruct(){
        if(is_resource($this->handle)){
            fclose($this->handle);
        }
    }

    public function read(){
        $this->handle = fopen($this->filename, 'r');
    }

    public function getRow(){
        return $this->current();
    }

}
