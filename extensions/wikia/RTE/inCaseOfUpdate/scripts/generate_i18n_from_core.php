<?php


function flatten($data, $index,&$langContainer,$currentLanguage,$i){
	foreach($data as $key => $entry){
		if ( gettype($entry) === 'object'){
			flatten($entry,$index . '-' . $key,$langContainer,$currentLanguage,$i);
		}
		else {
			$langContainer[$i][$currentLanguage][ "$index".'-'.$key ] = $entry;
		}
	}	
}


$languages = array();
$langCodes = array();
dl('json.so');
$files = trim(shell_exec("ls *js | grep -vP 'script|lang'"));
$files = explode(PHP_EOL, $files);
foreach ($files as $i => $file) {
	$currentLanguage =  explode('.',$file)[0];
	array_push($languages,array($currentLanguage => array()));
	array_push($langCodes,$currentLanguage);
	$data = json_decode(shell_exec("node scriptCore.js $file"));
	flatten($data,"rte-ck",$languages,$currentLanguage,$i);
}	


$out = "<?php\n";
$out .= '$messages = array();' . "\n";

foreach ($languages as $index  =>  $l) {
	$out .= "\$messages['$langCodes[$index]'] = " . var_export($l[$langCodes[$index]], true) . ";\n";
}

echo $out;

