<?php

namespace Minkiele\IpFilter\Row;

class P2P2DatTranslator implements Translator{
	public function translate($input){
		if(preg_match('/^([^:]*):(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})-(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $input, $matches) > 0){
			array_shift($matches);//Do not need the whole line
			$descr = array_shift($matches);

			$matches[] = str_replace(',', '', $descr);

			return vsprintf('%03s.%03s.%03s.%03s - %03s.%03s.%03s.%03s , 000 , %s', $matches);
		}else{
			throw new \Exception('Unknow Input Format');
		}
	}
}
