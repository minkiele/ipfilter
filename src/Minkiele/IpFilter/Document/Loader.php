<?php

namespace Minkiele\IpFilter\Document;

interface Loader extends \Iterator{
    public function load();
    public function getRow();
}
