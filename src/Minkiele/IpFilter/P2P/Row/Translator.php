<?php

namespace Minkiele\IpFilter\P2P\Row;
use Minkiele\IpFilter\Row\Translator as RowTranslator;
use Minkiele\IpFilter\Row\Row;
use Minkiele\IpFilter\IPv4;

class Translator implements RowTranslator{
	public function parse($input){
		if(preg_match('/^([^:]*):(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})-(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})$/', $input, $matches) > 0){
            return new Row(new IPv4($matches[2]), new IPv4($matches[3]), str_replace(',', '', $matches[1]));
		}else{
			throw new \Exception('Cannot parse the line');
		}
	}
  
    public function format(Row $input){
        throw new \Exception('Method not yet implemented');
    }
}
