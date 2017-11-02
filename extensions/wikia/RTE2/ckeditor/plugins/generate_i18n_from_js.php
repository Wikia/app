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

$desiredPluginNames = array();
array_push($desiredPluginNames,"basicstyles");
array_push($desiredPluginNames,"tabletools");



$languages = array();
$langCodes = array();

dl('json.so');
//foreach($desiredPluginNames as $key=>$pName){
//	$filePath = "./" . $desiredPluginNames[$key] ."/" . shell_exec("cd ".$desiredPluginNames[$key].";ls *js");
//	var_dump($filePath);
//}
$filePath = trim("./".$desiredPluginNames[0]."/lang/".shell_exec("cd ".$desiredPluginNames[0]."/lang/"));

$files = trim(shell_exec("cd ".$filePath. ";ls *js | grep -vP 'script|lang'"));

$files = explode(PHP_EOL, $files);

foreach($files as $key=>$file){
	$files[$key] = $filePath . $file;
//	array_push($langCodes,explode('.',$file)[0]);
}

//var_dump($files);


foreach ($files as $i => $file) {

	$currentLanguage =  explode('.',explode('/',$file)[3])[0];
	array_push($languages,array($currentLanguage => array()));
	array_push($langCodes,$currentLanguage);
	$data = json_decode(shell_exec("node script.js $file"));
	flatten($data,"rte-ck",$languages,$currentLanguage,$i);
//	var_dump($file);
}	


$out = "<?php\n";
$out .= '$messages = array();' . "\n";
//var_dump($langCodes);

foreach ($languages as $index  =>  $l) {
	$out .= "\$messages['$langCodes[$index]'] = " . var_export($l[$langCodes[$index]], true) . ";\n";
}

echo $out;

