<?php

namespace Minkiele\IpFilter\Document;

interface Reader extends \Iterator{
    public function read();
    public function getRow();
}
