<?php

namespace Minkiele\IpFilter\Row;

interface Translator {
  public function parse($input);
  public function format(Row $row);
}
