<?php

namespace Minkiele\IpFilter\Document;

interface Saver{
  public function addRow(Row $row);
  public function save();
}
