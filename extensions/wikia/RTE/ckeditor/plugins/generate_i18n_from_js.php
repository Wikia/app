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

function generatei18n($desiredPluginNames,$languages, $langCodes){

$merged = array();
$init = True;

foreach($desiredPluginNames as $pluginName){
		echo "Processing plugin: " . $pluginName . "\n";
		$languages = array();
		$langCodes = array();
		$filePath = trim("./".$pluginName."/lang/".shell_exec("cd ".$pluginName."/lang/"));

		$files = trim(shell_exec("cd ".$filePath. ";ls *js | grep -vP 'script|lang'"));

		$files = explode(PHP_EOL, $files);

		foreach($files as $key=>$file){
			$files[$key] = $filePath . $file;
		}


		foreach ($files as $i => $file) {

			$currentLanguage =  explode('.',explode('/',$file)[3])[0];
			array_push($languages,array($currentLanguage => array()));
			array_push($langCodes,$currentLanguage);
			$data = json_decode(shell_exec("node script.js $file"));
			flatten($data,"rte-ck-"."$pluginName",$languages,$currentLanguage,$i);
		}
		if($init === True){
			foreach($languages as $key => $value){			
				$merged[$key] = $languages[$key];
			}

		foreach($merged as $key => $value){
			foreach($value as $index => $val){
				$merged[$index] = $val;
				unset($merged[$key]);
			}
		}	

			$init = False;

		}

	
		foreach($languages as $key => $value){
			foreach($value as $index => $val){
				$languages[$index] = $val;
				unset($languages[$key]);
			}
		}
		

		foreach($langCodes as $key => $lCode){

			$merged[$lCode] = array_merge($merged[$lCode],$languages[$lCode]);

		}
	
	}
		$keys = array_keys($merged);
		$i = 0;
		foreach($merged as $key => $value){
			$merged[$i] = array($key => $merged[$keys[$i]]);
			unset($merged[$key]);
			$i = $i + 1;
		}
	return $merged;

}

$desiredPluginNames = array("toolbar","basicstyles","contextmenu","button","clipboard","fakeobjects","format","indent","list","pastetext","removeformat","sourcearea","undo","table","contextmenu","link","justify");



$languages = array();
$langCodes = array();

dl('json.so');

$result = generatei18n($desiredPluginNames,$languages,$langCodes);
foreach($result as $key => $value){
	foreach($value as $langCode => $val){
		array_push($langCodes,$langCode);;
	}
}

$out = "<?php\n";
$out .= '$messages = array();' . "\n";

foreach ($result as $index  =>  $l) {
	$out .= "\$messages['$langCodes[$index]'] = " . var_export($l[$langCodes[$index]], true) . ";\n";
}

echo $out;

