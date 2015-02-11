<?php

namespace Minkiele\IpFilter\Document;

interface Saver{
  public function putRow($row);
  public function save();
}
