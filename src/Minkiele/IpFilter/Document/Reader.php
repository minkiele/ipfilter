<?php

namespace Minkiele\IpFilter\Document;

interface Reader extends \Iterator{
    public function load();
    public function getRow();
}
