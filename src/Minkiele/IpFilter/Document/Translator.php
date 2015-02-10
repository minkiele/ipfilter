<?php

namespace Minkiele\IpFilter\Document;
use Minkiele\IpFilter\Row\P2PToDatTranslator;

class Translator{
	public function translateFile($filename){
		$handle = fopen($in, 'r+');
		$out = '';

		$translator = new P2PToDatTranslator();

		while(false !== ($line = fgets($handle))){
			try{
				$out .= $translator->translate($line) . PHP_EOL;
			}catch(\Exception $exc){

			}
		}

		fclose($handle);

		return $out;

	}
}
