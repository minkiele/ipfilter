<?php

namespace Minkiele\IpFilter\Document;

interface Writer{
  public function putRow($row);
  public function write();
}
