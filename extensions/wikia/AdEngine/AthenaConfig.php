<?php
header('Content-Type: text/plain');

// Hard code for now, eventually will pull from a database and stick in memcache
$object = new stdClass();
$object->adNetworkList=array(
	array(
		'network' => 'DART',
		'code' => 'alert("Hello from DART");'
	),
	array(
		'network' => 'Context ContextWeb',
		'code' => 'alert("Hello from Context Web");'
	),
	array(
		'network' => 'Google AdSense',
		'code' => 'alert("Hello from Google");'
	)
);

echo 'Athena.config = ' . json_encode($object) . ';';

?>
