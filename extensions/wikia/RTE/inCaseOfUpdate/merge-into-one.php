<?php

dl('json.so');

include('CK.core.i18n.phpCORE');
$coreMessages = $messages;
include('CK.core.i18n.phpPLUGINS');
$pluginsMessages = $messages;

$result = array();
if(count($coreMessages) >= count($pluginsMessages)){
	foreach($coreMessages as $langCode => $langArray){
		$result[$langCode] = array();
	}
}
else{
	foreach($pluginsMessages as $langCode => $langArray){
		$result[$langCode] = array();
	}

}
//echo count($result) . "\n";
foreach( $coreMessages as $langCode => $langArray ){
	$result[$langCode] = array_merge($result[$langCode], $langArray);	
}

//echo count($result) . "\n";

foreach( $pluginsMessages as $langCode => $langArray ){
	$result[$langCode] = array_merge($result[$langCode], $langArray);
}
//echo count($result) . "\n";

$out = "<?php\n";
$out .= '$messages = array();' . "\n";


foreach( $result as $langCode => $langArray ) {
	$out .= "\$messages['$langCode'] = " . var_export($langArray, true) . ";\n";
}

echo $out;
