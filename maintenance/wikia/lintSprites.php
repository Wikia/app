<?php

ini_set( "include_path", dirname(__FILE__)."/.." );

$optionsWithArgs = array(
	'sprite',
);
require_once( "commandLine.inc" );

function get_sprites_config() {
	global $IP;
	static $config;
	if ( $config === null ) {
		require "$IP/config/wikia/sprites.php";
	}
	return $config;
}

$sprites = get_sprites_config();

$names = isset($options['sprite']) ? [ $options['sprite'] ] : array_keys($sprites);
foreach ($names as $name) {
	$scss = $sprites[$name]['scss'];
	echo "Linting \"$name\"...\n";
	passthru('scss-lint -c ~/.scss-lint.yml ' . $scss);
}