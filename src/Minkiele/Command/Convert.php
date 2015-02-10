<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

$in = $_SERVER['argv'][1];

if($in === '-' || $in === null){
	$in = 'php://stdin';
}

$handle = fopen($in, 'r+');

$out = '';

while(false !== ($line = fgets($handle))){
	if(preg_match('/^([^:]*):(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})-(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $line, $matches) > 0){
		array_shift($matches);//Do not need the whole line
		$descr = array_shift($matches);

		$matches[] = str_replace(',', '', $descr);

		$out .= vsprintf('%03s.%03s.%03s.%03s - %03s.%03s.%03s.%03s , 000 , %s' . PHP_EOL, $matches);
	}else{
		//Silent error reporting
	}
}

fclose($handle);

echo $out;


