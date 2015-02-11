<?php

namespace Minkiele\IpFilter\Dat\Row;
use Minkiele\IpFilter\Row\Translator as RowTranslator;
use Minkiele\IpFilter\Row\Row;
use Minkiele\IpFilter\IPv4;

class Translator implements RowTranslator{
	public function parse($input){
        throw new \Exception('Method not yet implemented');
	}
  
    public function format(Row $input){

        $rangeStart = (string)$input->getRangeStart();
        $rangeEnd = (string)$input->getRangeEnd();

        $rangeStartArr = array_map('intval', explode('.', $rangeStart));
        $rangeEndArr = array_map('intval', explode('.', $rangeEnd));

        $data = array_merge($rangeStartArr, $rangeEndArr, $input->getAccessLevel(), $input->getComment());

        if(count($data) !== 8){
            return vsprintf('%03s.%03s.%03s.%03s - %03s.%03s.%03s.%03s , %s , %s', $data);
        }else{
            throw new \Exception('Input data not suitable for formatting');
        }
    }
}
